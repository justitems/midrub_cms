<?php

// Constants
defined('BASEPATH') OR exit('No direct script access allowed');

// Auth routes
$route['logout'] = 'base/logout';
$route['error/(:any)'] = 'error_page/show_error/$1';
$route['cron-job'] = 'cron/run';

// User routes
$route['user/success-payment'] = 'userarea/success_payment';
$route['user/option/(:any)'] = 'userarea/set_option/$1';
$route['user/delete-account'] = 'userarea/delete_user_account';
$route['user/save-token/(:any)/(:any)'] = 'userarea/save_token/$1/$2';
$route['user/connect/(:any)'] = 'userarea/connect/$1';
$route['user/disconnect/(:num)'] = 'userarea/disconnect/$1';
$route['user/callback/(:any)'] = 'userarea/callback/$1';
$route['user/verify-coupon/(:any)'] = 'coupons/verify_coupon/$1';
$route['user/ajax/(:any)'] = 'userarea/ajax/$1';

// Admin routes
$route['admin/home'] = 'adminarea/dashboard';
$route['admin/notifications'] = 'adminarea/notifications';
$route['admin/users'] = 'adminarea/users';
$route['admin/plans'] = 'plans_manager/admin_plans';
$route['admin/plans/(:num)'] = 'plans_manager/admin_plans/$1';
$route['admin/delete-plan/(:num)'] = 'adminarea/delete_plan/$1';
$route['admin/appearance'] = 'adminarea/appearance';
$route['admin/payment/(:any)'] = 'adminarea/payment/$1';
$route['admin/notification'] = 'adminarea/notification';
$route['admin/get-notifications'] = 'adminarea/get_notifications';
$route['admin/get-notification/(:num)'] = 'adminarea/get_notification/$1';
$route['admin/del-notification/(:num)'] = 'adminarea/del_notification/$1';
$route['admin/delete-user/(:num)'] = 'adminarea/delete_user/$1';
$route['admin/update-user'] = 'adminarea/update_user';
$route['admin/search-users/(:num)/(:any)'] = 'adminarea/search_users/$1/$2';
$route['admin/show-users/(:num)/(:num)'] = 'adminarea/show_users/$1/$2';
$route['admin/show-users/(:num)/(:num)/(:any)'] = 'adminarea/show_users/$1/$2/$3';
$route['admin/user-info/(:num)'] = 'adminarea/user_info/$1';
$route['admin/new-user'] = 'adminarea/new_user';
$route['admin/create-user'] = 'adminarea/create_user';
$route['admin/option/(:any)'] = 'adminarea/set_option/$1';
$route['admin/option/(:any)/(:any)'] = 'adminarea/set_option/$1/$2';
$route['admin/upmedia'] = 'adminarea/upmedia';
$route['admin/coupon-codes'] = 'coupons/codes';
$route['admin/coupon-codes/(:num)'] = 'coupons/get_all_codes/$1';
$route['admin/delete-code/(:any)'] = 'coupons/delete_code/$1';

$route['admin/ajax/options'] = 'adminarea/ajax/options';
$route['admin/ajax/plans'] = 'adminarea/ajax/plans';
$route['admin/ajax/faq'] = 'adminarea/ajax/faq';

// Default
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['default_controller'] = 'base/init';
$route['(:any)'] = 'base/init/$1';
$route['(:any)/(:any)'] = 'base/init/$1/$2';
$route['(:any)/(:any)/(:any)'] = 'base/init/$1/$2/$3';
$route['(:any)/(:any)/(:any)/(:any)'] = 'base/init/$1/$2/$3/$4';

/* End of file routes.php */