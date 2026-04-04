<?php

use chriskacerguis\RestServer\RestController;

class User_Controller extends RestController
{
    protected $current_user;

    public function __construct()
    {
        parent::__construct();

        // security headers
        $this->output->set_header('X-Frame-Options: DENY');
        $this->output->set_header('X-Content-Type-Options: nosniff');
        $this->output->set_header('X-XSS-Protection: 1; mode=block');
        $this->output->set_header('Access-Control-Allow-Origin: *');
        $this->output->set_header('Access-Control-Allow-Headers: Content-Type');

        $this->_check_rate_limit();

        $this->current_user = $this->session->userdata('user_id');
    }

    protected function require_auth()
    {
        if (!$this->current_user) {
            $this->response([
                'status' => false,
                'message' => 'Not authenticated'
            ], 401);
            exit;
        }
    }

    protected function require_role($role)
    {
        $user_role = $this->session->userdata('role');
        if ($user_role !== $role) {
            $this->response([
                'status' => false,
                'message' => 'Forbidden'
            ], 403);
            exit;
        }
    }

    private function _check_rate_limit()
    {
        $ip = $this->input->ip_address();
        $endpoint = $this->uri->uri_string();
        $limit = 60;
        $window = 60;

        $row = $this->db->where('ip_address', $ip)
            ->where('endpoint', $endpoint)
            ->where('window_start >', date('Y-m-d H:i:s', time() - $window))
            ->get('rate_limits')
            ->row();

        if ($row) {
            if ($row->requests >= $limit) {
                $this->response([
                    'status' => false,
                    'message' => 'Too many requests'
                ], 429);
                exit;
            }
            $this->db->where('id', $row->id)
                ->set('requests', 'requests + 1', false)
                ->update('rate_limits');
        } else {
            $this->db->insert('rate_limits', [
                'ip_address' => $ip,
                'endpoint' => $endpoint,
                'requests' => 1,
                'window_start' => date('Y-m-d H:i:s')
            ]);
        }
    }
}