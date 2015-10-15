<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*Web App Routes*/
//User routes
$route['default_controller'] = 'users';
$route['login'] = 'users/login';
$route['home'] = 'users/home';
$route['password'] = 'users/change_password';
$route['staff'] = 'users/staff';
$route['users/add'] = 'users/add';
$route['users/delete/(:any)'] = 'users/delete/$1';
$route['logout'] = 'users/logout';

// //Stop routes
// $route['stops'] = 'stops';
$route['stops/map/(:any)'] = 'stops/for_map/$1';
$route['/stops/add'] = 'stops/add';
$route['stops/edit/(:any)'] = 'stops/edit/$1';
$route['stops/delete/(:any)'] = 'stops/delete/$1';
$route['/stops/upload_img/(:any)'] = 'stops/upload_img/$1';
$route['/stops/upload_vid/(:any)'] = 'stops/upload_vid/$1';

// Map routes
$route['maps'] = 'maps';
$route['/maps/create'] = 'maps/create';
// $route['/maps/upload'] = 'maps/create';
$route['maps/edit/image/(:any)'] = 'maps/edit_image/$1';
$route['maps/edit/(:any)'] = 'maps/edit/$1';
$route['maps/delete/(:any)'] = 'maps/delete/$1';

//Media routes
$route['media/maps/delete/(:any)/(:any)'] = 'medias/map_delete/$1/$2';
$route['media/stop_images/delete/(:any)/(:any)'] = 'medias/stop_image_delete/$1/$2';
$route['media/stop_videos/delete/(:any)/(:any)'] = 'medias/stop_video_delete/$1/$2';
$route['media'] = 'medias/all';

//Android API routes
$route['csvirtualtour/maps/list'] = 'androids/maps';
$route['csvirtualtour/jsonapi/-1'] = 'androids/stops';
$route['csvirtualtour/jsonapi/(:any)'] = 'androids/stop/$1';

//iOS API Routes
$route['api/maps'] = 'iphones/maps';
$route['api/stops'] = 'iphones/stops';
$route['api/stops/map/(:any)'] = 'iphones/stops_for_map/$1';
$route['api/stops/(:any)'] = 'iphones/stop/$1';



$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

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
|	http://codeigniter.com/user_guide/general/routing.html
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
