<?php

require_once APPPATH . 'controllers/User_Controller.php';

class Analytics_Controller extends User_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->require_auth();
        $this->require_role('staff');
        $this->load->model('Analytics_Model');
    }

    // GET /api/v1/analytics/alumni
    public function alumni_get()
    {
        $programme = $this->get('programme');
        $grad_year = $this->get('grad_year');
        $industry = $this->get('industry');

        $alumni = $this->Analytics_Model->get_alumni($programme, $grad_year, $industry);

        $this->response([
            'status' => true,
            'count' => count($alumni),
            'alumni' => $alumni
        ], 200);
    }

    // GET /api/v1/analytics/skills-gap
    public function skills_gap_get()
    {
        $programme = $this->get('programme');
        $grad_year = $this->get('grad_year');

        $data = $this->Analytics_Model->get_skills_gap($programme, $grad_year);

        $this->response([
            'status' => true,
            'data' => $data
        ], 200);
    }

    // GET /api/v1/analytics/employment
    public function employment_get()
    {
        $programme = $this->get('programme');
        $grad_year = $this->get('grad_year');

        $data = $this->Analytics_Model->get_employment_by_sector($programme, $grad_year);

        $this->response([
            'status' => true,
            'data' => $data
        ], 200);
    }

    // GET /api/v1/analytics/job-titles
    public function job_titles_get()
    {
        $programme = $this->get('programme');
        $grad_year = $this->get('grad_year');

        $data = $this->Analytics_Model->get_job_titles($programme, $grad_year);

        $this->response([
            'status' => true,
            'data' => $data
        ], 200);
    }

    // GET /api/v1/analytics/employers
    public function employers_get()
    {
        $programme = $this->get('programme');
        $grad_year = $this->get('grad_year');
        $limit = $this->get('limit') ? (int)$this->get('limit') : 10;

        $data = $this->Analytics_Model->get_top_employers($programme, $grad_year, $limit);

        $this->response([
            'status' => true,
            'data' => $data
        ], 200);
    }

    // GET /api/v1/analytics/geographic
    public function geographic_get()
    {
        $programme = $this->get('programme');
        $grad_year = $this->get('grad_year');

        $data = $this->Analytics_Model->get_geographic($programme, $grad_year);

        $this->response([
            'status' => true,
            'data' => $data
        ], 200);
    }

    // GET /api/v1/analytics/certifications
    public function certifications_get()
    {
        $programme = $this->get('programme');
        $grad_year = $this->get('grad_year');

        $data = $this->Analytics_Model->get_certifications($programme, $grad_year);

        $this->response([
            'status' => true,
            'data' => $data
        ], 200);
    }

    // GET /api/v1/analytics/courses
    public function courses_get()
    {
        $programme = $this->get('programme');
        $grad_year = $this->get('grad_year');

        $data = $this->Analytics_Model->get_courses($programme, $grad_year);

        $this->response([
            'status' => true,
            'data' => $data
        ], 200);
    }

    // GET /api/v1/analytics/trends
    public function trends_get()
    {
        $programme = $this->get('programme');
        $grad_year = $this->get('grad_year');

        $data = $this->Analytics_Model->get_trends($programme, $grad_year);

        $this->response([
            'status' => true,
            'data' => $data
        ], 200);
    }

    // GET /api/v1/analytics/filters
    public function filters_get()
    {
        $this->response([
            'status' => true,
            'programmes' => $this->Analytics_Model->get_programmes(),
            'grad_years' => $this->Analytics_Model->get_grad_years()
        ], 200);
    }
}