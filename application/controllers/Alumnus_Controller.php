<?php

require_once APPPATH . 'controllers/User_Controller.php';

class Alumnus extends User_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_auth();
        $this->require_role('alumnus');
        $this->load->model('Alumnus_Model');
        $this->load->model('Bid_Model');
    }

    // GET /api/v1/alumnus/profile
    public function profile_get()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);

        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->response([
            'status' => true,
            'profile' => $profile,
            'degrees' => $this->Alumnus_Model->get_degrees($profile->id),
            'certifications' => $this->Alumnus_Model->get_certifications($profile->id),
            'licences' => $this->Alumnus_Model->get_licences($profile->id),
            'courses' => $this->Alumnus_Model->get_courses($profile->id),
            'employment' => $this->Alumnus_Model->get_employment($profile->id),
        ], 200);
    }

    // POST /api/v1/alumnus/profile
    public function profile_post()
    {
        $existing = $this->Alumnus_Model->get_profile($this->current_user);

        if ($existing) {
            $this->response(['status' => false, 'message' => 'Profile already exists'], 409);
            return;
        }

        $profile_id = $this->Alumnus_Model->create_profile($this->current_user);

        $this->response(['status' => true, 'message' => 'Profile created', 'profile_id' => $profile_id], 201);
    }

    // PUT /api/v1/alumnus/profile
    public function profile_put()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);

        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [];

        if ($this->put('linkedin_url')) {
            $linkedin = $this->put('linkedin_url');
            if (!filter_var($linkedin, FILTER_VALIDATE_URL)) {
                $this->response(['status' => false, 'message' => 'Invalid LinkedIn URL'], 400);
                return;
            }
            $data['linkedin_url'] = $linkedin;
        }

        if (empty($data)) {
            $this->response(['status' => false, 'message' => 'No data provided'], 400);
            return;
        }

        $this->Alumnus_Model->update_profile($this->current_user, $data);
        $this->Alumnus_Model->check_completion($profile->id);

        $this->response(['status' => true, 'message' => 'Profile updated'], 200);
    }

    // DELETE /api/v1/alumnus/profile
    public function profile_delete()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);

        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->Alumnus_Model->delete_profile($this->current_user);

        $this->response(['status' => true, 'message' => 'Profile deleted'], 200);
    }

    // POST /api/v1/alumnus/profile/image
    public function image_post()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);

        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        if (!isset($_FILES['image'])) {
            $this->response(['status' => false, 'message' => 'No image uploaded'], 400);
            return;
        }

        $config = [
            'upload_path' => FCPATH . 'uploads/',
            'allowed_types' => 'jpg|jpeg|png',
            'max_size' => 2048,
            'file_name' => 'user_' . $this->current_user
        ];

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')) {
            $this->response(['status' => false, 'message' => $this->upload->display_errors()], 400);
            return;
        }

        $image_path = 'uploads/' . $this->upload->data('file_name');
        $this->Alumnus_Model->update_profile($this->current_user, ['image_path' => $image_path]);

        $this->response(['status' => true, 'message' => 'Image uploaded', 'image_path' => $image_path], 200);
    }

    // Degrees
    public function degrees_get()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->response(['status' => true, 'degrees' => $this->Alumnus_Model->get_degrees($profile->id)], 200);
    }

    public function degrees_post()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [
            'institution' => $this->post('institution'),
            'qualification' => $this->post('qualification'),
            'grad_year' => $this->post('grad_year')
        ];

        if (!$data['institution'] || !$data['qualification']) {
            $this->response(['status' => false, 'message' => 'Institution and qualification are required'], 400);
            return;
        }

        $id = $this->Alumnus_Model->add_degree($profile->id, $data);
        $this->Alumnus_Model->check_completion($profile->id);

        $this->response(['status' => true, 'message' => 'Degree added', 'id' => $id], 201);
    }

    public function degrees_put($id = NULL)
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [
            'institution' => $this->put('institution'),
            'qualification' => $this->put('qualification'),
            'grad_year' => $this->put('grad_year')
        ];

        $this->Alumnus_Model->update_degree($id, $profile->id, array_filter($data));

        $this->response(['status' => true, 'message' => 'Degree updated'], 200);
    }

    public function degrees_delete($id = NULL)
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->Alumnus_Model->delete_degree($id, $profile->id);
        $this->Alumnus_Model->check_completion($profile->id);

        $this->response(['status' => true, 'message' => 'Degree deleted'], 200);
    }

    // Certifications
    public function certifications_get()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->response(['status' => true, 'certifications' => $this->Alumnus_Model->get_certifications($profile->id)], 200);
    }

    public function certifications_post()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [
            'title' => $this->post('title'),
            'issuer' => $this->post('issuer'),
            'issued_at' => $this->post('issued_at')
        ];

        if (!$data['title'] || !$data['issuer']) {
            $this->response(['status' => false, 'message' => 'Title and issuer are required'], 400);
            return;
        }

        $id = $this->Alumnus_Model->add_certification($profile->id, $data);

        $this->response(['status' => true, 'message' => 'Certification added', 'id' => $id], 201);
    }

    public function certifications_put($id = NULL)
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [
            'title' => $this->put('title'),
            'issuer' => $this->put('issuer'),
            'issued_at' => $this->put('issued_at')
        ];

        $this->Alumnus_Model->update_certification($id, $profile->id, array_filter($data));

        $this->response(['status' => true, 'message' => 'Certification updated'], 200);
    }

    public function certifications_delete($id = NULL)
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->Alumnus_Model->delete_certification($id, $profile->id);

        $this->response(['status' => true, 'message' => 'Certification deleted'], 200);
    }

    // Licences
    public function licences_get()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->response(['status' => true, 'licences' => $this->Alumnus_Model->get_licences($profile->id)], 200);
    }

    public function licences_post()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [
            'title' => $this->post('title'),
            'issuer' => $this->post('issuer'),
            'expires_at' => $this->post('expires_at')
        ];

        if (!$data['title'] || !$data['issuer']) {
            $this->response(['status' => false, 'message' => 'Title and issuer are required'], 400);
            return;
        }

        $id = $this->Alumnus_Model->add_licence($profile->id, $data);

        $this->response(['status' => true, 'message' => 'Licence added', 'id' => $id], 201);
    }

    public function licences_put($id = NULL)
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [
            'title' => $this->put('title'),
            'issuer' => $this->put('issuer'),
            'expires_at' => $this->put('expires_at')
        ];

        $this->Alumnus_Model->update_licence($id, $profile->id, array_filter($data));

        $this->response(['status' => true, 'message' => 'Licence updated'], 200);
    }

    public function licences_delete($id = NULL)
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->Alumnus_Model->delete_licence($id, $profile->id);

        $this->response(['status' => true, 'message' => 'Licence deleted'], 200);
    }

    // Courses
    public function courses_get()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->response(['status' => true, 'courses' => $this->Alumnus_Model->get_courses($profile->id)], 200);
    }

    public function courses_post()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [
            'title' => $this->post('title'),
            'provider' => $this->post('provider'),
            'completed_at' => $this->post('completed_at')
        ];

        if (!$data['title'] || !$data['provider']) {
            $this->response(['status' => false, 'message' => 'Title and provider are required'], 400);
            return;
        }

        $id = $this->Alumnus_Model->add_course($profile->id, $data);

        $this->response(['status' => true, 'message' => 'Course added', 'id' => $id], 201);
    }

    public function courses_put($id = NULL)
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [
            'title' => $this->put('title'),
            'provider' => $this->put('provider'),
            'completed_at' => $this->put('completed_at')
        ];

        $this->Alumnus_Model->update_course($id, $profile->id, array_filter($data));

        $this->response(['status' => true, 'message' => 'Course updated'], 200);
    }

    public function courses_delete($id = NULL)
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->Alumnus_Model->delete_course($id, $profile->id);

        $this->response(['status' => true, 'message' => 'Course deleted'], 200);
    }

    // Employment
    public function employment_get()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->response(['status' => true, 'employment' => $this->Alumnus_Model->get_employment($profile->id)], 200);
    }

    public function employment_post()
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [
            'company' => $this->post('company'),
            'role' => $this->post('role'),
            'start_date' => $this->post('start_date'),
            'end_date' => $this->post('end_date')
        ];

        if (!$data['company'] || !$data['role'] || !$data['start_date']) {
            $this->response(['status' => false, 'message' => 'Company, role and start date are required'], 400);
            return;
        }

        $id = $this->Alumnus_Model->add_employment($profile->id, $data);
        $this->Alumnus_Model->check_completion($profile->id);

        $this->response(['status' => true, 'message' => 'Employment added', 'id' => $id], 201);
    }

    public function employment_put($id = NULL)
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $data = [
            'company' => $this->put('company'),
            'role' => $this->put('role'),
            'start_date' => $this->put('start_date'),
            'end_date' => $this->put('end_date')
        ];

        $this->Alumnus_Model->update_employment($id, $profile->id, array_filter($data));
        $this->Alumnus_Model->check_completion($profile->id);

        $this->response(['status' => true, 'message' => 'Employment updated'], 200);
    }

    public function employment_delete($id = NULL)
    {
        $profile = $this->Alumnus_Model->get_profile($this->current_user);
        if (!$profile) {
            $this->response(['status' => false, 'message' => 'Profile not found'], 404);
            return;
        }

        $this->Alumnus_Model->delete_employment($id, $profile->id);
        $this->Alumnus_Model->check_completion($profile->id);

        $this->response(['status' => true, 'message' => 'Employment deleted'], 200);
    }

    // GET /api/v1/alumnus/bid/slot
    public function bid_slot_get()
    {
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $existing = $this->Bid_Model->get_active_bid($this->current_user, $tomorrow);

        $monthly_wins = $this->Bid_Model->get_monthly_win_count($this->current_user);
        $monthly_limit = $this->Bid_Model->get_monthly_limit($this->current_user);

        $this->response([
            'status' => true,
            'slot_date' => $tomorrow,
            'already_bid' => $existing ? true : false,
            'monthly_wins' => $monthly_wins,
            'monthly_limit' => $monthly_limit,
            'can_bid' => $monthly_wins < $monthly_limit
        ], 200);
    }

    // POST /api/v1/alumnus/bid
    public function bid_post()
    {
        $amount = $this->post('amount');
        $tomorrow = date('Y-m-d', strtotime('+1 day'));

        if (!$amount || !is_numeric($amount) || $amount <= 0) {
            $this->response(['status' => false, 'message' => 'A valid bid amount is required'], 400);
            return;
        }

        $monthly_wins = $this->Bid_Model->get_monthly_win_count($this->current_user);
        $monthly_limit = $this->Bid_Model->get_monthly_limit($this->current_user);

        if ($monthly_wins >= $monthly_limit) {
            $this->response(['status' => false, 'message' => 'Monthly bid limit reached'], 403);
            return;
        }

        $existing = $this->Bid_Model->get_active_bid($this->current_user, $tomorrow);

        if ($existing) {
            $this->response(['status' => false, 'message' => 'You already have an active bid for this slot'], 409);
            return;
        }

        $id = $this->Bid_Model->create($this->current_user, $tomorrow, $amount);

        $this->response(['status' => true, 'message' => 'Bid placed', 'bid_id' => $id], 201);
    }

    // PUT /api/v1/alumnus/bid/:id
    public function bid_put($id = NULL)
    {
        $amount = $this->put('amount');

        if (!$amount || !is_numeric($amount) || $amount <= 0) {
            $this->response(['status' => false, 'message' => 'A valid bid amount is required'], 400);
            return;
        }

        $bid = $this->Bid_Model->get_by_id($id, $this->current_user);

        if (!$bid) {
            $this->response(['status' => false, 'message' => 'Bid not found'], 404);
            return;
        }

        if ($amount <= $bid->amount) {
            $this->response(['status' => false, 'message' => 'New amount must be higher than current bid'], 400);
            return;
        }

        $this->Bid_Model->update_amount($id, $this->current_user, $amount);

        $this->response(['status' => true, 'message' => 'Bid updated'], 200);
    }

    // DELETE /api/v1/alumnus/bid/:id
    public function bid_delete($id = NULL)
    {
        $bid = $this->Bid_Model->get_by_id($id, $this->current_user);

        if (!$bid) {
            $this->response(['status' => false, 'message' => 'Bid not found'], 404);
            return;
        }

        $this->Bid_Model->cancel($id, $this->current_user);

        $this->response(['status' => true, 'message' => 'Bid cancelled'], 200);
    }

    // GET /api/v1/alumnus/bid/status
    public function bid_status_get()
    {
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $bid = $this->Bid_Model->get_active_bid($this->current_user, $tomorrow);

        if (!$bid) {
            $this->response(['status' => false, 'message' => 'No active bid found'], 404);
            return;
        }

        $this->response([
            'status' => true,
            'bid_id' => $bid->id,
            'slot_date' => $bid->slot_date,
            'amount' => $bid->amount,
            'bid_status' => $bid->status
        ], 200);
    }

    // GET /api/v1/alumnus/bid/history
    public function bid_history_get()
    {
        $history = $this->Bid_Model->get_history($this->current_user);

        $this->response(['status' => true, 'bids' => $history], 200);
    }

    // GET /api/v1/alumnus/bid/limit
    public function bid_limit_get()
    {
        $monthly_wins = $this->Bid_Model->get_monthly_win_count($this->current_user);
        $monthly_limit = $this->Bid_Model->get_monthly_limit($this->current_user);

        $this->response([
            'status' => true,
            'monthly_wins' => $monthly_wins,
            'monthly_limit' => $monthly_limit,
            'remaining' => $monthly_limit - $monthly_wins
        ], 200);
    }
}