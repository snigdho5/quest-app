<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'site';
$route['unavailable'] = 'site/unavailable';

// backend
$route['admin'] = 'admin/login/index';
$route['admin/(:any)'] = 'admin/$1';
$route['admin/(:any)/(:any)'] = 'admin/$1/$2';
$route['admin/(:any)/(:any)/(:any)'] = 'admin/$1/$2/$3';

// ajax
$route['ajax/(:any)'] = 'ajax/$1';

// frontend
	

	// end dynamic routing

$route['who-trendsetter'] = 'site/whoTrendsetter';
$route['why-trendsetter'] = 'site/whyTrendsetter';


$route['(:any)'] = 'site/index/$1';
$route['(:any)/(:any)'] = 'site/index/$1/$2';
$route['(:any)/(:any)/(:any)'] = 'site/index/$1/$2/$3';




$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
