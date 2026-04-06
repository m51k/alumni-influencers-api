<?php

require_once APPPATH . 'controllers/User_Controller.php';

class Api_Controller extends User_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Bid_Model');
        $this->load->model('Alumnus_Model');
        $this->load->model('Api_Key_Model');
    }

    // GET /api/v1/alumni/today
    public function today_get() {
        $header = $this->input->get_request_header('Authorization');

        if (!$header || !preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            $this->response(['status' => false, 'message' => 'API key required'], 401);
            return;
        }

        $api_key = $this->Api_Key_Model->find_by_key($matches[1]);

        if (!$api_key) {
            $this->response(['status' => false, 'message' => 'Invalid or revoked API key'], 401);
            return;
        }

        $this->Api_Key_Model->log_access(
            $api_key->id,
            $this->uri->uri_string(),
            'GET'
        );

        $winner = $this->select_winner();

        if (!$winner) {
            $this->response(['status' => false, 'message' => 'No featured alumnus today'], 404);
            return;
        }

        $this->update_appearance_count($winner->slot_date);

        $profile = $this->Alumnus_Model->get_profile($winner->user_id);

        $this->response([
            'status'           => true,
            'slot_date'        => $winner->slot_date,
            'appearance_count' => $winner->appearance_count + 1,
            'profile'          => $profile,
            'degrees'          => $this->Alumnus_Model->get_degrees($profile->id),
            'certifications'   => $this->Alumnus_Model->get_certifications($profile->id),
            'licences'         => $this->Alumnus_Model->get_licences($profile->id),
            'courses'          => $this->Alumnus_Model->get_courses($profile->id),
            'employment'       => $this->Alumnus_Model->get_employment($profile->id),
        ], 200);
    }

    private function select_winner() {
        $today = date('Y-m-d');

        $existing = $this->Bid_Model->get_active_winner();
        if ($existing && $existing->slot_date === $today) {
            return $existing;
        }

        $bid = $this->Bid_Model->get_highest_bid($today);

        if (!$bid) {
            return NULL;
        }

        $monthly_wins  = $this->Bid_Model->get_monthly_win_count($bid->user_id);
        $monthly_limit = $this->Bid_Model->get_monthly_limit($bid->user_id);

        if ($monthly_wins >= $monthly_limit) {
            return NULL;
        }

        $this->Bid_Model->create_winner($bid->id, $today);

        return $this->Bid_Model->get_active_winner();
    }

    private function update_appearance_count($slot_date) {
        $this->db->where('slot_date', $slot_date)
            ->set('appearance_count', 'appearance_count + 1', FALSE)
            ->update('bid_winners');
    }
}