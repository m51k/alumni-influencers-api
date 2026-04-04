<?php

class User_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function create($email, $password, $role)
    {
        $this->db->insert('users', [
            'email' => $email,
            'password_hash' => password_hash($password, PASSWORD_BCRYPT),
            'is_verified' => 0,
            'role' => $role,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        return $this->db->insert_id();
    }

    public function find_by_id($id)
    {
        return $this->db->where('id', $id)
            ->get('users')
            ->row();
    }

    public function find_by_email($email)
    {
        return $this->db->where('email', $email)
            ->get('users')
            ->row();
    }

    public function check_password($plain, $hash)
    {
        return password_verify($plain, $hash);
    }

    public function verify($user_id)
    {
        $this->db->where('id', $user_id)
            ->update('users', ['is_verified' => 1]);
    }

    public function update_password($user_id, $new_password)
    {
        $this->db->where('id', $user_id)
            ->update('users', [
                'password_hash' => password_hash($new_password, PASSWORD_BCRYPT)
            ]);
    }

    public function delete($user_id)
    {
        $this->db->where('id', $user_id)
            ->delete('users');
    }
}