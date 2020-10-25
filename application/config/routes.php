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
| my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = "login";
$route['404_override'] = 'error';


/*********** USER DEFINED ROUTES *******************/

$route['loginMe']         = 'login/loginMe';
$route['dashboard']       = 'user';
$route['logout']          = 'user/logout';

$route['user']            = 'user/userlist';
$route['user/(:num)']     = "user/userlist/$1";
$route['user/add']        = "user/add";
$route['user/add/(:num)'] = "user/add/$1";
$route['user/delete']     = "user/delete";

$route['changeavatar']    = "user/changeavatar";
$route['updateavatar']    = "user/updateavatar";

$route['changepass']      = "user/changepass";
$route['updatepassword']  = "user/updatepassword";


$route['pageNotFound']     = "user/pageNotFound";
$route['checkEmailExists'] = "user/checkEmailExists";

$route['forgotpassword']                         = "login/forgotpassword";
$route['resetPasswordUser']                      = "login/resetPasswordUser";
$route['resetPasswordConfirmUser']               = "login/resetPasswordConfirmUser";
$route['resetPasswordConfirmUser/(:any)']        = "login/resetPasswordConfirmUser/$1";
$route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";
$route['createPasswordUser']                     = "login/createPasswordUser";


// Student Routing
$route['students']             = "students/studentlist";
$route['students/(:num)']      = "students/studentlist/$1";
$route['students/add']         = "students/add";
$route['students/edit']        = "students/edit";
$route['students/edit/(:num)'] = "students/edit/$1";
$route['students/delete']      = "students/delete";
$route['students/view/(:num)'] = "students/view/$1";

// Subjects Routing
$route['subjects']            = "subjects/subjectlist";
$route['subjects/(:num)']     = "subjects/subjectlist/$1";
$route['subjects/add']        = "subjects/add";
$route['subjects/add/(:num)'] = "subjects/add/$1";
$route['subjects/delete']     = "subjects/delete";

// Mark Distribution
$route['markdistribution']            = "markdistribution/mlist";
$route['markdistribution/(:num)']     = "markdistribution/mlist/$1";
$route['markdistribution/add']        = "markdistribution/add";
$route['markdistribution/add/(:num)'] = "markdistribution/add/$1";
$route['markdistribution/delete']     = "markdistribution/delete";

// Class Routing
$route['classes']            = "classes/classlist";
$route['classes/(:num)']     = "classes/classlist/$1";
$route['classes/add']        = "classes/add";
$route['classes/add/(:num)'] = "classes/add/$1";
$route['classes/delete']     = "classes/delete";

// Department Routing
$route['departments']            = "departments/departmentslist";
$route['departments/(:num)']     = "departments/departmentslist/$1";
$route['departments/add']        = "departments/add";
$route['departments/add/(:num)'] = "departments/add/$1";
$route['departments/delete']     = "departments/delete";

// Exam Routing
$route['exam']                 = "exam/examlist";
$route['exam/(:num)']          = "exam/examlist/$1";
$route['exam/add']             = "exam/add";
$route['exam/add/(:num)']      = "exam/add/$1";
$route['exam/savehere']        = "exam/savehere";
$route['exam/savehere/(:num)'] = "exam/savehere/$1";
$route['exam/delete']          = "exam/delete";

// Grade Routing
$route['grade']            = "grade/gradelist";
$route['grade/(:num)']     = "grade/gradelist/$1";
$route['grade/add']        = "grade/add";
$route['grade/add/(:num)'] = "grade/add/$1";
$route['grade/delete']     = "grade/delete";

// Grade Category Routing
$route['gradecat']            = "gradecat/gradecatlist";
$route['gradecat/(:num)']     = "gradecat/gradecatlist/$1";
$route['gradecat/add']        = "gradecat/add";
$route['gradecat/add/(:num)'] = "gradecat/add/$1";
$route['gradecat/delete']     = "gradecat/delete";

// Mark
$route['mark']          = "mark/add";
$route['mark/savemark'] = "mark/savemark";

// Result
$route['result']         = "result/form";
$route['result/details'] = "result/show_result";

$route['results']         = "results";
$route['results/details'] = "results/details";

// tabulation
$route['tabulation']         = "tabulation/form";
$route['tabulation/details'] = "tabulation/show_result";

// configuration Routing
$route['configuration']      = "configuration";
$route['configuration/edit'] = "configuration/edit";

// Field Routing
$route['fields']            = "fields/fieldslist";
$route['fields/(:num)']     = "fields/fieldslist/$1";
$route['fields/add']        = "fields/add";
$route['fields/add/(:num)'] = "fields/add/$1";
$route['fields/delete']     = "fields/delete";

// languages Routing
$route['languages']            = "languages/languagelist";
$route['languages/(:num)']     = "languages/languagelist/$1";
$route['languages/add']        = "languages/add";
$route['languages/add/(:num)'] = "languages/add/$1";
$route['languages/delete']     = "languages/delete";

$route['certificate']         = "certificate";
$route['certificate/details'] = "certificate/details";

$route['backup']  = "backup";
$route['modules'] = "modules";

// Result Template
$route['result_template']                       = 'result_template';
$route['result_template/getlogin']            = 'result_template/getlogin';
$route['result_template/getdelete']             = 'result_template/getdelete';
$route['result_template/configuration/(:num)']  = "result_template/configuration/$1";
$route['result_template/configuration_save']    = "result_template/configuration_save";

// Update
$route['update']                = 'update';
$route['update/login']        = 'update/getInstall';
