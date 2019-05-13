<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller']     = 'welcome';
$route['404_override']           = '';
$route['translate_uri_dashes']   = FALSE;

$route['admin']                   =  'admin/login';
$route['admin/check-login']       =  'admin/login/check_login';
$route['admin/register']          =  'admin/login/register';
$route['admin/validation-token']  =  'admin/login/validation_token';
$route['admin/activated']         =	 'admin/login/activated';
$route['admin/forgot-password']   =  'admin/login/forgot_password';
$route['admin/reset-password']    =  'admin/login/reset_password';

/*Users*/
$route['admin/users/(:num)']              =  'admin/users';
$route['admin/users/create']              =  'admin/users/create';
$route['admin/users/edit/(:num)']         =  'admin/users/update/$1';
$route['admin/users/delete/(:num)']       =  'admin/users/delete/$1';
$route['admin/users/role']                =  'admin/users/role';
$route['admin/users/role/create']         =  'admin/users/role_create';
$route['admin/users/role/edit/(:num)']    =  'admin/users/role_update/$1';
$route['admin/users/role/delete/(:num)']  =  'admin/users/role_delete/$1';
$route['admin/users/group']               =  'admin/users/group';
$route['admin/users/group/create']        =  'admin/users/group_create';
$route['admin/users/group/edit/(:num)']   =  'admin/users/group_update/$1';
$route['admin/users/group/delete/(:num)'] =  'admin/users/group_delete/$1';

/*Info*/
$route['admin/info']                      =  'admin/info/update';

/*fields*/
$route['admin/fields']                     = 'admin/fields';
$route['admin/fields/create']              = 'admin/fields/create';
$route['admin/fields/edit/(:num)']         = 'admin/fields/update/$1';
$route['admin/fields/delete/(:num)']       = 'admin/fields/delete/$1';
$route['admin/fields/group']               = 'admin/fields/group';
$route['admin/fields/group/create']        = 'admin/fields/group_create';
$route['admin/fields/group/edit/(:num)']   = 'admin/fields/group_update/$1';
$route['admin/fields/group/delete/(:num)'] = 'admin/fields/group_delete/$1';
$route['admin/fields/type']                = 'admin/fields/type';
$route['admin/fields/type/create']         = 'admin/fields/type_create';
$route['admin/fields/type/edit/(:num)']    = 'admin/fields/type_update/$1';
$route['admin/fields/type/delete/(:num)']  = 'admin/fields/type_delete/$1';

/*Section*/
$route['admin/section']                       = 'admin/section';
$route['admin/section/create']                = 'admin/section/create';
$route['admin/section/edit/(:num)']           = 'admin/section/update/$1';
$route['admin/section/delete/(:num)']         = 'admin/section/delete/$1';
$route['admin/section/type']                  = 'admin/section/type';
$route['admin/section/type/create']           = 'admin/section/type_create';
$route['admin/section/type/edit/(:num)']      = 'admin/section/type_update/$1';
$route['admin/section/type/delete/(:num)']    = 'admin/section/type_delete/$1';
/*Entries*/
$route['admin/section/(:num)/entrytypes']             = 'admin/section/entrytypes/$1';
$route['admin/section/(:num)/entrytypes/create']      = 'admin/section/entrytypes_create/$1';
$route['admin/section/(:num)/entrytypes/edit/(:num)'] = 'admin/section/entrytypes_update/$1/$2';
$route['admin/section/(:num)/entrytypes/delete/(:num)'] = 'admin/section/entrytypes_delete/$1/$2';


/*Content*/
$route['admin/entries']                       = 'admin/entries';
$route['admin/entries/create']                = 'admin/entries/create';
$route['admin/entries/edit/(:num)']           = 'admin/entries/update/$1';
$route['admin/entries/delete/(:num)']         = 'admin/entries/delete/$1';

/*Assets*/
$route['admin/assets']                       = 'admin/assets';
$route['admin/assets/create']                = 'admin/assets/create';
$route['admin/assets/edit/(:num)']           = 'admin/assets/update/$1';
$route['admin/assets/delete/(:num)']         = 'admin/assets/delete/$1';

/*categories*/
$route['admin/categories']                       = 'admin/categories';
$route['admin/categories/create']                = 'admin/categories/create';
$route['admin/categories/edit/(:num)']           = 'admin/categories/update/$1';
$route['admin/categories/delete/(:num)']         = 'admin/categories/delete/$1';

// settings 
$route['admin/settings'] = 'admin/settings';