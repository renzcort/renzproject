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

/*Field*/
$route['admin/field']                     = 'admin/field';
$route['admin/field/create']              = 'admin/field/create';
$route['admin/field/edit/(:num)']         = 'admin/field/update/$1';
$route['admin/field/delete/(:num)']       = 'admin/field/delete/$1';
$route['admin/field/group']               = 'admin/field/group';
$route['admin/field/group/create']        = 'admin/field/group_create';
$route['admin/field/group/edit/(:num)']   = 'admin/field/group_update/$1';
$route['admin/field/group/delete/(:num)'] = 'admin/field/group_delete/$1';
$route['admin/field/type']                = 'admin/field/type';
$route['admin/field/type/create']         = 'admin/field/type_create';
$route['admin/field/type/edit/(:num)']    = 'admin/field/type_update/$1';
$route['admin/field/type/delete/(:num)']  = 'admin/field/type_delete/$1';

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
$route['admin/section/entries']               = 'admin/section/entries_section';
$route['admin/section/entries/create']        = 'admin/section/entries_section_create';
$route['admin/section/entries/edit/(:num)']   = 'admin/section/entries_section_update/$1';
$route['admin/section/entries/delete/(:num)'] = 'admin/section/entries_section_delete/$1';


/*Content*/
$route['admin/entries']                       = 'admin/entries';
$route['admin/entries/create']                = 'admin/entries/create';
$route['admin/entries/edit/(:num)']           = 'admin/entries/update/$1';
$route['admin/entries/delete/(:num)']         = 'admin/entries/delete/$1';