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
$route['default_controller']   = 'welcome';
$route['404_override']         = '';
$route['translate_uri_dashes'] = FALSE;

$route['admin']                  =  'admin/login';
$route['admin/check-login']      =  'admin/login/check_login';
$route['admin/register']         =  'admin/login/register';
$route['admin/validation-token'] =  'admin/login/validation_token';
$route['admin/activated']        =	 'admin/login/activated';
$route['admin/forgot-password']  =  'admin/login/forgot_password';
$route['admin/reset-password']   =  'admin/login/reset_password';

/*Users*/
$route['admin/settings/users/(:num)']              =  'admin/users';
$route['admin/settings/users/create']              =  'admin/users/create';
$route['admin/settings/users/edit/(:num)']         =  'admin/users/update/$1';
$route['admin/settings/users/delete/(:num)']       =  'admin/users/delete/$1';
$route['admin/settings/users/role']                =  'admin/users/role';
$route['admin/settings/users/role/create']         =  'admin/users/role_create';
$route['admin/settings/users/role/edit/(:num)']    =  'admin/users/role_update/$1';
$route['admin/settings/users/role/delete/(:num)']  =  'admin/users/role_delete/$1';
$route['admin/settings/users/(:any)']              =  'admin/users/settings/$1';
$route['admin/settings/users/(:any)/create']       =  'admin/users/settings_create/$1';
$route['admin/settings/users/(:any)/edit/(:any)']  =  'admin/users/settings_update/$1/$2';
$route['admin/settings/users/(:any)/delete/(:num)']=  'admin/users/settings_delete/$1/$2';

/*Info*/
$route['admin/info'] =  'admin/info/update';

/*fields*/
$route['admin/settings/fields']                    = 'admin/fields';
$route['admin/settings/fields/create']             = 'admin/fields/create';
$route['admin/settings/fields/edit/(:num)']        = 'admin/fields/update/$1';
$route['admin/settings/fields/delete/(:num)']      = 'admin/fields/delete/$1';
$route['admin/settings/fields/type']               = 'admin/fields/type';
$route['admin/settings/fields/type/create']        = 'admin/fields/type_create';
$route['admin/settings/fields/type/edit/(:num)']   = 'admin/fields/type_update/$1';
$route['admin/settings/fields/type/delete/(:num)'] = 'admin/fields/type_delete/$1';

/*Section*/
$route['admin/settings/section']                                 = 'admin/section';
$route['admin/settings/section/create']                          = 'admin/section/create';
$route['admin/settings/section/edit/(:num)']                     = 'admin/section/update/$1';
$route['admin/settings/section/delete/(:num)']                   = 'admin/section/delete/$1';
$route['admin/settings/section/type']                            = 'admin/section/type';
$route['admin/settings/section/type/create']                     = 'admin/section/type_create';
$route['admin/settings/section/type/edit/(:num)']                = 'admin/section/type_update/$1';
$route['admin/settings/section/type/delete/(:num)']              = 'admin/section/type_delete/$1';
$route['admin/settings/section/(:num)/entrytypes']               = 'admin/section/entrytypes/$1';
$route['admin/settings/section/(:num)/entrytypes/create']        = 'admin/section/entrytypes_create/$1';
$route['admin/settings/section/(:num)/entrytypes/edit/(:num)']   = 'admin/section/entrytypes_update/$1/$2';
$route['admin/settings/section/(:num)/entrytypes/delete/(:num)'] = 'admin/section/entrytypes_delete/$1/$2';


/*Content*/
$route['admin/entries/(:any)']               = 'admin/entries/index/$1';
$route['admin/entries/(:any)/create']        = 'admin/entries/create/$1';
$route['admin/entries/(:any)/edit/(:num)']   = 'admin/entries/update/$1/$2';
$route['admin/entries/(:any)/delete/(:num)'] = 'admin/entries/delete/$1/$2';

/*Assets*/
$route['admin/settings/assets']                          = 'admin/assets/volumes';
$route['admin/settings/assets/create']                   = 'admin/assets/volumes_create';
$route['admin/settings/assets/edit/(:num)']              = 'admin/assets/volumes_update/$1';
$route['admin/settings/assets/delete/(:num)']            = 'admin/assets/volumes_delete/$1';
$route['admin/settings/assets/transforms']               = 'admin/assets/transforms';
$route['admin/settings/assets/transforms/create']        = 'admin/assets/transforms_create';
$route['admin/settings/assets/transforms/edit/(:num)']   = 'admin/assets/transforms_update/$1';
$route['admin/settings/assets/transforms/delete/(:num)'] = 'admin/assets/transforms_delete/$1';
$route['admin/assets/(:any)']                            = 'admin/assets/index/$1';
$route['admin/assets/create']                            = 'admin/assets/create';
$route['admin/assets/edit/(:num)']                       = 'admin/assets/update/$1';
$route['admin/assets/delete/(:num)']                     = 'admin/assets/delete/$1';

/*categories*/
$route['admin/categories/(:any)']                 = 'admin/categories/index/$1';
$route['admin/categories/create/(:any)']          = 'admin/categories/create/$1';
$route['admin/categories/edit/(:any)/(:num)']     = 'admin/categories/update/$1/$2';
$route['admin/categories/delete/(:any)/(:num)']   = 'admin/categories/delete/$1/$2';
$route['admin/settings/categories']               = 'admin/categories/groups/';
$route['admin/settings/categories/create']        = 'admin/categories/groups_create';
$route['admin/settings/categories/edit/(:num)']   = 'admin/categories/groups_update/$1';
$route['admin/settings/categories/delete/(:num)'] = 'admin/categories/groups_delete/$1';

/*Sites*/
$route['admin/settings/sites']               = 'admin/sites';
$route['admin/settings/sites/create']        = 'admin/sites/create';
$route['admin/settings/sites/edit/(:num)']   = 'admin/sites/update/$1';
$route['admin/settings/sites/delete/(:num)'] = 'admin/sites/delete/$1';

/*Globals*/
$route['admin/globals/(:any)']                 	= 'admin/globals/index/$1';
$route['admin/globals/create/(:any)']          	= 'admin/globals/create/$1';
$route['admin/globals/edit/(:any)/(:num)']     	= 'admin/globals/update/$1/$2';
$route['admin/globals/delete/(:any)/(:num)']   	= 'admin/globals/delete/$1/$2';
$route['admin/settings/globals']               	= 'admin/globals/groups';
$route['admin/settings/globals/create']        	= 'admin/globals/groups_create';
$route['admin/settings/globals/edit/(:num)']   	= 'admin/globals/groups_update/$1';
$route['admin/settings/globals/delete/(:num)'] 	= 'admin/globals/groups_delete/$1';


// settings 
$route['admin/settings']         = 'admin/settings';
$route['admin/settings/general'] = 'admin/general';
$route['admin/settings/email']   = 'admin/email';