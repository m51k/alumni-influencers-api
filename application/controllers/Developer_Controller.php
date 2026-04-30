<?php

require_once APPPATH . 'controllers/User_Controller.php';

class Developer_Controller extends User_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_auth();
        $this->require_role('developer');
        $this->load->model('Api_Key_Model');
    }

    // POST /api/v1/developer/keys
    public function keys_post()
    {
        $label = $this->post('label');
        $permissions = $this->post('permissions');

        if (!$label) {
            $this->response(['status' => false, 'message' => 'Label is required'], 400);
            return;
        }

        $valid_permissions = ['read:alumni_of_day', 'read:alumni', 'read:analytics'];
        $requested = $permissions ? explode(',', $permissions) : ['read:alumni_of_day'];

        foreach ($requested as $p) {
            if (!in_array(trim($p), $valid_permissions)) {
                $this->response(['status' => false, 'message' => 'Invalid permission: ' . trim($p)], 400);
                return;
            }
        }

        $permissions_string = implode(',', array_map('trim', $requested));

        $key = $this->Api_Key_Model->create($this->current_user, $label, $permissions_string);

        $this->response([
            'status' => true,
            'message' => 'API key generated. Store this key safely — it will not be shown again.',
            'id' => $this->db->insert_id(),
            'key' => $key,
            'permissions' => $permissions_string
        ], 201);
    }

    // GET /api/v1/developer/keys
    public function keys_get()
    {
        $keys = $this->Api_Key_Model->get_all($this->current_user);

        $this->response(['status' => true, 'keys' => $keys], 200);
    }

    // GET /api/v1/developer/keys/:id/stats
    public function stats_get($id = NULL)
    {
        $key = $this->Api_Key_Model->get_by_id($id, $this->current_user);

        if (!$key) {
            $this->response(['status' => false, 'message' => 'API key not found'], 404);
            return;
        }

        $stats = $this->Api_Key_Model->get_stats($key->id);

        $this->response([
            'status' => true,
            'key' => $key,
            'logs' => $stats
        ], 200);
    }

    // DELETE /api/v1/developer/keys/:id
    public function keys_delete($id = NULL)
    {
        $key = $this->Api_Key_Model->get_by_id($id, $this->current_user);

        if (!$key) {
            $this->response(['status' => false, 'message' => 'API key not found'], 404);
            return;
        }

        if (!$key->is_active) {
            $this->response(['status' => false, 'message' => 'API key already revoked'], 409);
            return;
        }

        $this->Api_Key_Model->revoke($id, $this->current_user);

        $this->response(['status' => true, 'message' => 'API key revoked'], 200);
    }
}