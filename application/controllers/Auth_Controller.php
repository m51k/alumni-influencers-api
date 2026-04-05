<?php

require_once APPPATH . 'controllers/User_Controller.php';

class Auth_Controller extends User_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->model('Token_Model');
        $this->load->library('email');
    }

    public function ping_get()
    {
        $this->response([
            'status' => true,
            'message' => 'API is working'
        ], 200);
    }

    // POST /api/v1/auth/register
    public function register_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');
        $role = $this->post('role');

        if (!$email || !$password || !$role) {
            $this->response(['status' => false, 'message' => 'Email, password and role are required'], 400);
            return;
        }

        if (!preg_match('/^[^@]+@eastminster\.ac\.uk$/', $email)) {
            $this->response(['status' => false, 'message' => 'Email must be a valid @iit.ac.lk address'], 400);
            return;
        }

        if (!in_array($role, ['alumnus', 'developer'])) {
            $this->response(['status' => false, 'message' => 'Role must be alumnus or developer'], 400);
            return;
        }

        if (strlen($password) < 8) {
            $this->response(['status' => false, 'message' => 'Password must be at least 8 characters'], 400);
            return;
        }

        if ($this->User_Model->find_by_email($email)) {
            $this->response(['status' => false, 'message' => 'Email already registered'], 409);
            return;
        }

        $user_id = $this->User_Model->create($email, $password, $role);

        if ($role === 'alumnus') {
            $this->load->model('Alumnus_Model');
            $this->Alumnus_Model->create_profile($user_id);
        }

        $token = $this->Token_Model->create($user_id, 'verify');

        $verify_url = base_url('index.php/api/v1/auth/verify/' . $token);
        $this->email->from('noreply@eastminster.ac.uk', 'Eastminster Alumni');
        $this->email->to($email);
        $this->email->subject('Verify your account');
        $this->email->message('Click the link to verify your account: ' . $verify_url);
        $this->email->send();

        $this->response(['status' => true, 'message' => 'Registered successfully. Please check your email to verify your account.'], 201);
    }

    // GET /api/v1/auth/verify/:token
    public function verify_get($token = NULL)
    {
        if (!$token) {
            $this->response(['status' => false, 'message' => 'Token is required'], 400);
            return;
        }

        $row = $this->Token_Model->find($token, 'verify');

        if (!$row) {
            $this->response(['status' => false, 'message' => 'Invalid or expired token'], 400);
            return;
        }

        $this->User_Model->verify($row->user_id);
        $this->Token_Model->consume($row->id);

        $this->response(['status' => true, 'message' => 'Email verified successfully'], 200);
    }

    // POST /api/v1/auth/login
    public function login_post()
    {
        $email = $this->post('email');
        $password = $this->post('password');

        if (!$email || !$password) {
            $this->response(['status' => false, 'message' => 'Email and password are required'], 400);
            return;
        }

        $user = $this->User_Model->find_by_email($email);

        if (!$user || !$this->User_Model->check_password($password, $user->password_hash)) {
            $this->response(['status' => false, 'message' => 'Invalid credentials'], 401);
            return;
        }

        if (!$user->is_verified) {
            $this->response(['status' => false, 'message' => 'Please verify your email before logging in'], 403);
            return;
        }

        $this->session->set_userdata([
            'user_id' => $user->id,
            'role' => $user->role
        ]);

        $this->response(['status' => true, 'message' => 'Logged in successfully'], 200);
    }

    // POST /api/v1/auth/logout
    public function logout_post()
    {
        $this->session->sess_destroy();
        $this->response(['status' => true, 'message' => 'Logged out successfully'], 200);
    }

    // POST /api/v1/auth/forgot-password
    public function forgot_password_post()
    {
        $email = $this->post('email');

        if (!$email) {
            $this->response(['status' => false, 'message' => 'Email is required'], 400);
            return;
        }

        $user = $this->User_Model->find_by_email($email);

        // always return 200 to prevent email enumeration
        if (!$user) {
            $this->response(['status' => true, 'message' => 'If that email exists you will receive a reset link'], 200);
            return;
        }

        $token = $this->Token_Model->create($user->id, 'reset');

        $reset_url = base_url('index.php/api/v1/auth/reset-password/' . $token);
        $this->email->from('noreply@eastminster.ac.uk', 'Eastminster Alumni');
        $this->email->to($email);
        $this->email->subject('Reset your password');
        $this->email->message('Click the link to reset your password: ' . $reset_url);
        $this->email->send();

        $this->response(['status' => true, 'message' => 'If that email exists you will receive a reset link'], 200);
    }

    // POST /api/v1/auth/reset-password
    public function reset_password_post()
    {
        $token = $this->post('token');
        $password = $this->post('password');

        if (!$token || !$password) {
            $this->response(['status' => false, 'message' => 'Token and new password are required'], 400);
            return;
        }

        if (strlen($password) < 8) {
            $this->response(['status' => false, 'message' => 'Password must be at least 8 characters'], 400);
            return;
        }

        $row = $this->Token_Model->find($token, 'reset');

        if (!$row) {
            $this->response(['status' => false, 'message' => 'Invalid or expired token'], 400);
            return;
        }

        $this->User_Model->update_password($row->user_id, $password);
        $this->Token_Model->consume($row->id);

        $this->response(['status' => true, 'message' => 'Password reset successfully'], 200);
    }
}