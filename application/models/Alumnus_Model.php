<?php

require_once APPPATH . 'models/User_Model.php';

class Alumnus_Model extends User_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // Profile
    public function get_profile($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->get('profiles')
            ->row();
    }

    public function create_profile($user_id)
    {
        $this->db->insert('profiles', [
            'user_id' => $user_id,
            'linkedin_url' => NULL,
            'image_path' => NULL,
            'is_complete' => 0
        ]);
        return $this->db->insert_id();
    }

    public function update_profile($user_id, $data)
    {
        $this->db->where('user_id', $user_id)
            ->update('profiles', $data);
    }

    public function delete_profile($user_id)
    {
        $this->db->where('user_id', $user_id)
            ->delete('profiles');
    }

    public function check_completion($profile_id)
    {
        $has_degree = $this->db->where('profile_id', $profile_id)->count_all_results('degrees') > 0;
        $has_employment = $this->db->where('profile_id', $profile_id)->count_all_results('employment') > 0;

        $is_complete = $has_degree && $has_employment ? 1 : 0;

        $this->db->where('id', $profile_id)
            ->update('profiles', ['is_complete' => $is_complete]);
    }

    // Degrees
    public function get_degrees($profile_id)
    {
        return $this->db->where('profile_id', $profile_id)
            ->get('degrees')
            ->result();
    }

    public function add_degree($profile_id, $data)
    {
        $data['profile_id'] = $profile_id;
        $this->db->insert('degrees', $data);
        return $this->db->insert_id();
    }

    public function update_degree($id, $profile_id, $data)
    {
        $this->db->where('id', $id)
            ->where('profile_id', $profile_id)
            ->update('degrees', $data);
    }

    public function delete_degree($id, $profile_id)
    {
        $this->db->where('id', $id)
            ->where('profile_id', $profile_id)
            ->delete('degrees');
    }

    // Certifications
    public function get_certifications($profile_id)
    {
        return $this->db->where('profile_id', $profile_id)
            ->get('certifications')
            ->result();
    }

    public function add_certification($profile_id, $data)
    {
        $data['profile_id'] = $profile_id;
        $this->db->insert('certifications', $data);
        return $this->db->insert_id();
    }

    public function update_certification($id, $profile_id, $data)
    {
        $this->db->where('id', $id)
            ->where('profile_id', $profile_id)
            ->update('certifications', $data);
    }

    public function delete_certification($id, $profile_id)
    {
        $this->db->where('id', $id)
            ->where('profile_id', $profile_id)
            ->delete('certifications');
    }

    // Licences
    public function get_licences($profile_id)
    {
        return $this->db->where('profile_id', $profile_id)
            ->get('licences')
            ->result();
    }

    public function add_licence($profile_id, $data)
    {
        $data['profile_id'] = $profile_id;
        $this->db->insert('licences', $data);
        return $this->db->insert_id();
    }

    public function update_licence($id, $profile_id, $data)
    {
        $this->db->where('id', $id)
            ->where('profile_id', $profile_id)
            ->update('licences', $data);
    }

    public function delete_licence($id, $profile_id)
    {
        $this->db->where('id', $id)
            ->where('profile_id', $profile_id)
            ->delete('licences');
    }

    // Courses
    public function get_courses($profile_id)
    {
        return $this->db->where('profile_id', $profile_id)
            ->get('courses')
            ->result();
    }

    public function add_course($profile_id, $data)
    {
        $data['profile_id'] = $profile_id;
        $this->db->insert('courses', $data);
        return $this->db->insert_id();
    }

    public function update_course($id, $profile_id, $data)
    {
        $this->db->where('id', $id)
            ->where('profile_id', $profile_id)
            ->update('courses', $data);
    }

    public function delete_course($id, $profile_id)
    {
        $this->db->where('id', $id)
            ->where('profile_id', $profile_id)
            ->delete('courses');
    }

    // Employment
    public function get_employment($profile_id)
    {
        return $this->db->where('profile_id', $profile_id)
            ->get('employment')
            ->result();
    }

    public function add_employment($profile_id, $data)
    {
        $data['profile_id'] = $profile_id;
        $this->db->insert('employment', $data);
        return $this->db->insert_id();
    }

    public function update_employment($id, $profile_id, $data)
    {
        $this->db->where('id', $id)
            ->where('profile_id', $profile_id)
            ->update('employment', $data);
    }

    public function delete_employment($id, $profile_id)
    {
        $this->db->where('id', $id)
            ->where('profile_id', $profile_id)
            ->delete('employment');
    }
}