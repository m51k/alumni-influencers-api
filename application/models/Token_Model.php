<?php

class Token_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create($user_id, $type)
    {
        // SHA256
        $token = bin2hex(random_bytes(32));

        $this->db->insert('tokens', [
            'user_id' => $user_id,
            'token_hash' => hash('sha256', $token),
            'type' => $type,
            'expires_at' => date('Y-m-d H:i:s', time() + 3600),
            'used_at' => NULL
        ]);

        return $token;
    }

    public function find($token, $type)
    {
        return $this->db->where('token_hash', hash('sha256', $token))
            ->where('type', $type)
            ->where('used_at', NULL)
            ->where('expires_at >', date('Y-m-d H:i:s'))
            ->get('tokens')
            ->row();
    }

    public function consume($token_id)
    {
        $this->db->where('id', $token_id)
            ->update('tokens', [
                'used_at' => date('Y-m-d H:i:s')
            ]);
    }
}