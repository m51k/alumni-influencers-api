<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Profile
$route['api/v1/auth/ping'] = 'Auth_Controller/ping';
$route['api/v1/auth/register'] = 'Auth_Controller/register';
$route['api/v1/auth/verify/(:any)'] = 'Auth_Controller/verify/$1';
$route['api/v1/auth/login'] = 'Auth_Controller/login';
$route['api/v1/auth/logout'] = 'Auth_Controller/logout';
$route['api/v1/auth/forgot-password'] = 'Auth_Controller/forgot_password';
$route['api/v1/auth/reset-password'] = 'Auth_Controller/reset_password';

// Alumnus
$route['api/v1/alumnus/profile'] = 'Alumnus_Controller/profile';
$route['api/v1/alumnus/profile/image'] = 'Alumnus_Controller/image';
$route['api/v1/alumnus/degrees'] = 'Alumnus_Controller/degrees';
$route['api/v1/alumnus/degrees/(:num)'] = 'Alumnus_Controller/degrees/$1';
$route['api/v1/alumnus/certifications'] = 'Alumnus_Controller/certifications';
$route['api/v1/alumnus/certifications/(:num)'] = 'Alumnus_Controller/certifications/$1';
$route['api/v1/alumnus/licences'] = 'Alumnus_Controller/licences';
$route['api/v1/alumnus/licences/(:num)'] = 'Alumnus_Controller/licences/$1';
$route['api/v1/alumnus/courses'] = 'Alumnus_Controller/courses';
$route['api/v1/alumnus/courses/(:num)'] = 'Alumnus_Controller/courses/$1';
$route['api/v1/alumnus/employment'] = 'Alumnus_Controller/employment';
$route['api/v1/alumnus/employment/(:num)'] = 'Alumnus_Controller/employment/$1';

$route['api/v1/alumnus/bid/slot'] = 'Alumnus_Controller/bid_slot';
$route['api/v1/alumnus/bid/status'] = 'Alumnus_Controller/bid_status';
$route['api/v1/alumnus/bid/history'] = 'Alumnus_Controller/bid_history';
$route['api/v1/alumnus/bid/limit'] = 'Alumnus_Controller/bid_limit';
$route['api/v1/alumnus/bid'] = 'Alumnus_Controller/bid';
$route['api/v1/alumnus/bid/(:num)'] = 'Alumnus_Controller/bid/$1';

$route['api/v1/alumnus/event'] = 'Alumnus_Controller/event';

// Developer
$route['api/v1/developer/keys'] = 'Developer_Controller/keys';
$route['api/v1/developer/keys/(:num)/stats'] = 'Developer_Controller/stats/$1';
$route['api/v1/developer/keys/(:num)'] = 'Developer_Controller/keys/$1';

// API
$route['api/v1/alumni/today'] = 'Api_Controller/today';

// Analytics
$route['api/v1/analytics/alumni'] = 'Analytics_Controller/alumni';
$route['api/v1/analytics/skills-gap'] = 'Analytics_Controller/skills_gap';
$route['api/v1/analytics/employment'] = 'Analytics_Controller/employment';
$route['api/v1/analytics/job-titles'] = 'Analytics_Controller/job_titles';
$route['api/v1/analytics/employers'] = 'Analytics_Controller/employers';
$route['api/v1/analytics/geographic'] = 'Analytics_Controller/geographic';
$route['api/v1/analytics/certifications'] = 'Analytics_Controller/certifications';
$route['api/v1/analytics/courses'] = 'Analytics_Controller/courses';
$route['api/v1/analytics/trends'] = 'Analytics_Controller/trends';
$route['api/v1/analytics/filters'] = 'Analytics_Controller/filters';
