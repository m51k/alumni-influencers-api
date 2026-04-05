<?php

class Api_Key_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create($user_id, $label)
    {
        $key = bin2hex(random_bytes(32));

        $this->db->insert('api_keys', [
            'user_id' => $user_id,
            'key_hash' => hash('sha256', $key),
            'label' => $label,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return $key;
    }

    public function get_all($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->get('api_keys')
            ->result();
    }

    public function get_by_id($id, $user_id)
    {
        return $this->db->where('id', $id)
            ->where('user_id', $user_id)
            ->get('api_keys')
            ->row();
    }

    public function find_by_key($key)
    {
        return $this->db->where('key_hash', hash('sha256', $key))
            ->where('is_active', 1)
            ->get('api_keys')
            ->row();
    }

    public function get_stats($api_key_id)
    {
        return $this->db->where('api_key_id', $api_key_id)
            ->order_by('accessed_at', 'DESC')
            ->get('api_key_logs')
            ->result();
    }

    public function log_access($api_key_id, $endpoint, $method)
    {
        $this->db->insert('api_key_logs', [
            'api_key_id' => $api_key_id,
            'endpoint' => $endpoint,
            'method' => $method,
            'accessed_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function revoke($id, $user_id)
    {
        $this->db->where('id', $id)
            ->where('user_id', $user_id)
            ->update('api_keys', [
                'is_active' => 0,
                'revoked_at' => date('Y-m-d H:i:s')
            ]);
    }
}