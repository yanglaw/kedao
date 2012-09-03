<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * LimeSurvey
 * Copyright (C) 2007-2011 The LimeSurvey Project Team / Carsten Schmitz
 * All rights reserved.
 * License: GNU/GPL License v2 or later, see LICENSE.php
 * LimeSurvey is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 *
 *	$Id$
 */
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
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

//Compatibility with classic modrewrite
$route['(:num)/lang-(:any)/tk-(:any)'] = "survey/sid/$1/lang/$2/token/$3"; //This one must be first
$route['(:num)/lang-(:any)'] = "survey/sid/$1/lang/$2";
$route['(:num)/tk-(:any)'] = "survey/sid/$1/token/$2";
$route['(:num)'] = "survey/sid/$1";

//Admin Routes
$route['admin/index'] = "admin";
$route['admin/<action:\w+>/<sa:\w+>/*'] = 'admin/<action>/sa/<sa>';

//question
$route['admin/question/newquestion/(:num)/(:num)'] = "admin/question/index/addquestion/$1/$2";
$route['admin/question/editquestion/(:num)/(:num)/(:num)'] = "admin/question/index/editquestion/$1/$2/$3";

$route['admin/labels/<action:\w+>'] = "admin/labels/index/<action>";
$route['admin/labels/<action:\w+>/<lid:\d+>'] = "admin/labels/index/<action>/<id>";

$route['<controller:\w+>/<action:\w+>'] = '<controller>/<action>';

//Expression Manager tests
$route['admin/expressions'] = "admin/expressions/index";

//optout
$route['optout/(:num)/(:any)/(:any)'] = "optout/index/$1/$2/$3";

return $route;
