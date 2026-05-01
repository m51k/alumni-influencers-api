<?php

class Analytics_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    private function apply_filters($programme = NULL, $grad_year = NULL)
    {
        if ($programme) {
            $this->db->where('profiles.programme', $programme);
        }
        if ($grad_year) {
            $this->db->where('degrees.grad_year', $grad_year);
        }
    }

    public function get_alumni($programme = NULL, $grad_year = NULL, $industry = NULL)
    {
        // GROUP_CONCAT combines multiple employment roles into a single comma-separated string so one row is returned per alumnus
        $this->db->select('users.id, users.email, profiles.programme, profiles.location, profiles.linkedin_url, profiles.image_path, profiles.is_complete, GROUP_CONCAT(employment.role SEPARATOR ", ") as roles')
            ->from('users')
            ->join('profiles', 'profiles.user_id = users.id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->join('employment', 'employment.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus');

        if ($programme) {
            $this->db->where('profiles.programme', $programme);
        }
        if ($grad_year) {
            $this->db->where('degrees.grad_year', $grad_year);
        }
        if ($industry) {
            $this->db->like('employment.role', $industry);
        }

        return $this->db->group_by('users.id')
            ->get()
            ->result();
    }

    public function get_skills_gap($programme = NULL, $grad_year = NULL)
    {
        $this->db->select('certifications.title, COUNT(*) as count')
            ->from('certifications')
            ->join('profiles', 'profiles.id = certifications.profile_id')
            ->join('users', 'users.id = profiles.user_id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus');

        $this->apply_filters($programme, $grad_year);

        $certs = $this->db->group_by('certifications.title')
            ->order_by('count', 'DESC')
            ->get()
            ->result();

        $this->db->select('courses.title, COUNT(*) as count')
            ->from('courses')
            ->join('profiles', 'profiles.id = courses.profile_id')
            ->join('users', 'users.id = profiles.user_id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus');

        $this->apply_filters($programme, $grad_year);

        $courses = $this->db->group_by('courses.title')
            ->order_by('count', 'DESC')
            ->get()
            ->result();

        return ['certifications' => $certs, 'courses' => $courses];
    }

    public function get_employment_by_sector($programme = NULL, $grad_year = NULL)
    {
        $this->db->select('employment.role as sector, COUNT(*) as count')
            ->from('employment')
            ->join('profiles', 'profiles.id = employment.profile_id')
            ->join('users', 'users.id = profiles.user_id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus');

        $this->apply_filters($programme, $grad_year);

        return $this->db->group_by('employment.role')
            ->order_by('count', 'DESC')
            ->get()
            ->result();
    }

    public function get_job_titles($programme = NULL, $grad_year = NULL)
    {
        $this->db->select('employment.role as title, COUNT(*) as count')
            ->from('employment')
            ->join('profiles', 'profiles.id = employment.profile_id')
            ->join('users', 'users.id = profiles.user_id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus');

        $this->apply_filters($programme, $grad_year);

        return $this->db->group_by('employment.role')
            ->order_by('count', 'DESC')
            ->limit(10)
            ->get()
            ->result();
    }

    public function get_top_employers($programme = NULL, $grad_year = NULL, $limit = 10)
    {
        $this->db->select('employment.company, COUNT(*) as count')
            ->from('employment')
            ->join('profiles', 'profiles.id = employment.profile_id')
            ->join('users', 'users.id = profiles.user_id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus');

        $this->apply_filters($programme, $grad_year);

        return $this->db->group_by('employment.company')
            ->order_by('count', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function get_geographic($programme = NULL, $grad_year = NULL)
    {
        $this->db->select('profiles.location, COUNT(*) as count')
            ->from('profiles')
            ->join('users', 'users.id = profiles.user_id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus')
            ->where('profiles.location IS NOT NULL', NULL, FALSE);

        $this->apply_filters($programme, $grad_year);

        return $this->db->group_by('profiles.location')
            ->order_by('count', 'DESC')
            ->get()
            ->result();
    }

    public function get_certifications($programme = NULL, $grad_year = NULL)
    {
        $this->db->select('certifications.title, certifications.issuer, COUNT(*) as count')
            ->from('certifications')
            ->join('profiles', 'profiles.id = certifications.profile_id')
            ->join('users', 'users.id = profiles.user_id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus');

        $this->apply_filters($programme, $grad_year);

        return $this->db->group_by('certifications.title')
            ->order_by('count', 'DESC')
            ->limit(10)
            ->get()
            ->result();
    }

    public function get_courses($programme = NULL, $grad_year = NULL)
    {
        $this->db->select('courses.title, courses.provider, COUNT(*) as count')
            ->from('courses')
            ->join('profiles', 'profiles.id = courses.profile_id')
            ->join('users', 'users.id = profiles.user_id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus');

        $this->apply_filters($programme, $grad_year);

        return $this->db->group_by('courses.title')
            ->order_by('count', 'DESC')
            ->limit(10)
            ->get()
            ->result();
    }

    public function get_trends($programme = NULL, $grad_year = NULL)
    {
        $this->db->select('YEAR(certifications.issued_at) as year, MONTH(certifications.issued_at) as month, COUNT(*) as count')
            ->from('certifications')
            ->join('profiles', 'profiles.id = certifications.profile_id')
            ->join('users', 'users.id = profiles.user_id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus')
            ->where('certifications.issued_at IS NOT NULL', NULL, FALSE);

        $this->apply_filters($programme, $grad_year);

        $cert_trends = $this->db->group_by('year, month')
            ->order_by('year, month', 'ASC')
            ->get()
            ->result();

        $this->db->select('YEAR(courses.completed_at) as year, MONTH(courses.completed_at) as month, COUNT(*) as count')
            ->from('courses')
            ->join('profiles', 'profiles.id = courses.profile_id')
            ->join('users', 'users.id = profiles.user_id')
            ->join('degrees', 'degrees.profile_id = profiles.id', 'left')
            ->where('users.role', 'alumnus')
            ->where('courses.completed_at IS NOT NULL', NULL, FALSE);

        $this->apply_filters($programme, $grad_year);

        $course_trends = $this->db->group_by('year, month')
            ->order_by('year, month', 'ASC')
            ->get()
            ->result();

        return ['certifications' => $cert_trends, 'courses' => $course_trends];
    }

    public function get_programmes()
    {
        return $this->db->distinct()
            ->select('programme')
            ->where('programme IS NOT NULL', NULL, FALSE)
            ->get('profiles')
            ->result();
    }

    public function get_grad_years()
    {
        return $this->db->distinct()
            ->select('grad_year')
            ->where('grad_year IS NOT NULL', NULL, FALSE)
            ->order_by('grad_year', 'DESC')
            ->get('degrees')
            ->result();
    }
}