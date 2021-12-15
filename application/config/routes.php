<?php

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Auth routes
$route['logout'] = 'base/logout';
$route['error/(:any)'] = 'error_page/show_error/$1';
$route['cron-job'] = 'cron/run';

// Default
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'base/init';
$route['user/connect/(:any)'] = 'networks/connect/$1';
$route['user/callback/(:any)'] = 'networks/callback/$1';
$route['(:any)'] = 'base/init/$1';
$route['(:any)/(:any)'] = 'base/init/$1/$2';
$route['(:any)/(:any)/(:any)'] = 'base/init/$1/$2/$3';
$route['(:any)/(:any)/(:any)/(:any)'] = 'base/init/$1/$2/$3/$4';

/* End of file routes.php */