<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
//login Module
//'middleware' => 'checkAuth',

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, X-XSRF-TOKEN, Origin, Authorization, _token, api_token, X-CSRF-TOKEN');
Route::get('/', [
    'as' => 'login',
    'uses' => 'LoginController@index',
]);
Route::get('/logout', [
    'as' => 'logout',
    'uses' => 'DashboardController@logout',
]);
Route::post('/login', [
    'as' => 'login.check',
    'uses' => 'LoginController@checkLogin',
]);

Route::post('/forgotpassword', [
    'as' => 'forgotpassword',
    'uses' => 'LoginController@forgotpassword',
]);
Route::group(['middleware' => 'dept'], function () {
//Dashboard 
Route::get('/dashboard', [
    'as' => 'dashboard',
    'uses' => 'DashboardController@index',
]);

//Group module
Route::get('/group', [
    'as' => 'group',
    'uses' => 'GroupController@index',
]);
Route::get('/group/data', [
    'as' => 'group.data',
    'uses' => 'GroupController@anyData',
]);
Route::get('group/add', [
    'as' => 'group.add',
    'uses' => 'GroupController@create',
]);
Route::post('group/add', [
    'as' => 'group.add',
    'uses' => 'GroupController@store',
]);
Route::get('group/view/{page}', [
    'as' => 'group.view',
    'uses' => 'GroupController@view',
]);
Route::get('group/edit/{page}', [
    'as' => 'group.edit',
    'uses' => 'GroupController@edit',
]);
Route::post('group/edit/{page}', [
    'as' => 'group.edit',
    'uses' => 'GroupController@update',
]);
Route::get('group/{page}/delete', [
    'as' => 'group.delete',
    'uses' => 'GroupController@destroy',
]);

//Category module

Route::get('/category', [
    'as' => 'category',
    'uses' => 'CategoryController@index',
]);
Route::get('/category/data', [
    'as' => 'category.data',
    'uses' => 'CategoryController@anyData',
]);
Route::get('category/add', [
    'as' => 'category.add',
    'uses' => 'CategoryController@create',
]);
Route::post('category/add', [
    'as' => 'category.add',
    'uses' => 'CategoryController@store',
]);
Route::get('category/view/{page}', [
    'as' => 'category.view',
    'uses' => 'CategoryController@view',
]);
Route::get('category/edit/{page}', [
    'as' => 'category.edit',
    'uses' => 'CategoryController@edit',
]);
Route::post('category/edit/{page}', [
    'as' => 'category.edit',
    'uses' => 'CategoryController@update',
]);
Route::get('category/{page}/delete', [
    'as' => 'category.delete',
    'uses' => 'CategoryController@destroy',
]);

//Auditlogs module
Route::any('/auditlogs', [
    'as' => 'auditlogs',
    'uses' => 'AuditlogsController@index',
]);
Route::get('/auditlogs/data', [
    'as' => 'auditlogs.data',
    'uses' => 'AuditlogsController@anyData',
]);


//Questions module
Route::get('/questions', [
    'as' => 'questions',
    'uses' => 'QuestionController@index',
]);
Route::get('/questions/data', [
    'as' => 'questions.data',
    'uses' => 'QuestionController@getData',
]);
Route::post('/questions/all', [
    'as' => 'questions.all',
    'uses' => 'QuestionController@questions_list',
]);
Route::get('/questions/all', [
    'as' => 'questions.all',
    'uses' => 'QuestionController@questions_list',
]);
Route::get('questions/add', [
    'as' => 'questions.add',
    'uses' => 'QuestionController@create',
]);
Route::post('questions/add', [
    'as' => 'questions.add',
    'uses' => 'QuestionController@store',
]);
Route::get('questions/view/{page}', [
    'as' => 'questions.view',
    'uses' => 'QuestionController@view',
]);
Route::get('questions/edit/{page}', [
    'as' => 'questions.edit',
    'uses' => 'QuestionController@edit',
]);
Route::post('questions/edit/{page}', [
    'as' => 'questions.edit',
    'uses' => 'QuestionController@update',
]);
Route::get('questions/{page}/delete', [
    'as' => 'questions.delete',
    'uses' => 'QuestionController@destroy',
]);

//User module
Route::get('/users', [
    'as' => 'users',
    'uses' => 'UserController@index',
]);
Route::get('/users/data', [
    'as' => 'users.data',
    'uses' => 'UserController@getData',
]);
Route::get('users/add', [
    'as' => 'users.add',
    'uses' => 'UserController@create',
]);
Route::post('users/add', [
    'as' => 'users.add',
    'uses' => 'UserController@store',
]);
Route::get('users/view/{page}', [
    'as' => 'users.view',
    'uses' => 'UserController@view',
]);
Route::get('users/edit/{page}', [
    'as' => 'users.edit',
    'uses' => 'UserController@edit',
]);
Route::post('users/edit/{page}', [
    'as' => 'users.edit',
    'uses' => 'UserController@update',
]);
Route::get('users/{page}/delete', [
    'as' => 'users.delete',
    'uses' => 'UserController@destroy',
]);

//Form module
Route::get('/form', [
    'as' => 'form',
    'uses' => 'FormController@index',
]);
Route::get('/form/data', [
    'as' => 'form.data',
    'uses' => 'FormController@getData',
]);
Route::get('form/add', [
    'as' => 'form.add',
    'uses' => 'FormController@create',
]);
Route::post('form/add', [
    'as' => 'form.add',
    'uses' => 'FormController@store',
]);
Route::post('form/preview', [
    'as' => 'form.preview',
    'uses' => 'FormController@preview',
]);
Route::post('form/getCatInfo', [
    'as' => 'form.getCatInfo',
    'uses' => 'FormController@getCatInfo',
]);
Route::post('form/groups', [
    'as' => 'form.group',
    'uses' => 'FormController@groups',
]);
Route::post('form/users', [
    'as' => 'form.user',
    'uses' => 'FormController@users',
]);
Route::post('form/linkGroups', [
    'as' => 'form.linkGroup',
    'uses' => 'FormController@linkGroups',
]);
Route::post('form/linkUsers', [
    'as' => 'form.linkUser',
    'uses' => 'FormController@linkUsers',
]);
Route::get('form/view/{page}', [
    'as' => 'form.view',
    'uses' => 'FormController@view',
]);
Route::get('form/edit/{page}', [
    'as' => 'form.edit',
    'uses' => 'FormController@edit',
]);
Route::post('form/edit/{page}', [
    'as' => 'form.edit',
    'uses' => 'FormController@update',
]);
Route::get('form/{page}/delete', [
    'as' => 'form.delete',
    'uses' => 'FormController@destroy',
]);
Route::any('form/getUserForms', [
    'as' => 'form.getUserForms',
    'uses' => 'FormController@getUserForms',
]);
Route::get('form/getUserFormData', [
    'as' => 'form.getUserFormData',
    'uses' => 'FormController@getUserFormData',
]);
Route::get('form/userFormView/{page}', [
    'as' => 'form.userFormView',
    'uses' => 'FormController@userFormView',
]);
//Profile
Route::get('/profile', [
    'as' => 'profile',
    'uses' => 'ProfileController@index',
]);
Route::get('profile/update/{page}', [
    'as' => 'profile.update',
    'uses' => 'ProfileController@edit',
]);
Route::post('profile/update/{page}', [
    'as' => 'profile.update',
    'uses' => 'ProfileController@update',
]);
//Notifications
Route::get('/notifications', [
    'as' => 'notifications', 
    'uses' => 'NotificationController@index',
]);
Route::get('/notifications/data', [
    'as' => 'notifications.data',
    'uses' => 'NotificationController@getData',
]);
Route::post('/updateNotification', [
    'as' => 'updateNotification', 
    'uses' => 'NotificationController@updateNotification',
]);


//Reports
Route::get('/reports', [
    'as' => 'reports', 
    'uses' => 'ReportsController@index',
]);

Route::any('reports/userforms', [
    'as' => 'reports.userforms', 
    'uses' => 'ReportsController@userforms',
]);
Route::any('reports/userFormCount', [
    'as' => 'reports.userFormCount', 
    'uses' => 'ReportsController@userFormCount',
]);
Route::any('reports/questionExpectedReport', [
    'as' => 'reports.questionExpectedReport', 
    'uses' => 'ReportsController@questionExpectedReport',
]);
Route::any('reports/categoryExpectedReport', [
    'as' => 'reports.categoryExpectedReport', 
    'uses' => 'ReportsController@categoryExpectedReport',
]);

});
//Admin user module
Route::get('/admin/users', [
    'as' => 'admin.users',
    'uses' => 'admin\UserController@index',
]);
Route::get('/admin/users/data', [
    'as' => 'admin.users.data',
    'uses' => 'admin\UserController@getData',
]);
Route::get('admin/users/add', [
    'as' => 'admin.users.add',
    'uses' => 'admin\UserController@create',
]);
Route::post('admin/users/add', [
    'as' => 'admin.users.add',
    'uses' => 'admin\UserController@store',
]);
Route::get('admin/users/view/{page}', [
    'as' => 'admin.users.view',
    'uses' => 'admin\UserController@view',
]);
Route::get('admin/users/edit/{page}', [
    'as' => 'admin.users.edit',
    'uses' => 'admin\UserController@edit',
]);
Route::post('admin/users/edit/{page}', [
    'as' => 'admin.users.edit',
    'uses' => 'admin\UserController@update',
]);
Route::get('admin/users/{page}/delete', [
    'as' => 'admin.users.delete',
    'uses' => 'admin\UserController@destroy',
]);

// API routes...

//For customer creation
Route::post('/api/customerCreate', [
    'as' => 'api.customerCreate',
    'uses' => 'api\CustomerController@create',
]);
Route::post('/api/customerList', [
    'as' => 'api.customerList',
    'uses' => 'api\CustomerController@customerList',
]);
Route::post('/api/customerPayment', [
    'as' => 'api.customerPayment',
    'uses' => 'api\CustomerController@customerPayment',
]);
Route::post('/api/customerPaymentList', [
    'as' => 'api.customerPaymentList',
    'uses' => 'api\CustomerController@paymentList',
]);
Route::post('/api/userDates', [
    'as' => 'api.userDates',
    'uses' => 'api\CustomerController@userDates',
]);
Route::post('/api/customerView', [
    'as' => 'api.customerView',
    'uses' => 'api\CustomerController@customerView',
]);



Route::post('/api/checkAuth', [
    'as' => 'api.checkAuth',
    'middleware' => 'checkAuth',
    'uses' => 'api\ApiController@checkAuth',
]);
Route::get('/api/token', [
    'as' => 'api.token',
    'uses' => 'api\ApiController@getToken',
]);
Route::post('/api/login', [
    'as' => 'api.login.check',
    'uses' => 'api\LoginController@checkLogin',
]);
Route::post('/api/forgotpassword', [
    'as' => 'api.forgotpassword',
    'uses' => 'api\LoginController@forgotpassword',
]);
Route::post('/api/changePassword', [
    'as' => 'api.changePassword',
    'uses' => 'api\UserController@changePassword',
]);
//get template list
Route::post('/api/templates', [
    'as' => 'api.templates',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@getTemplates',
]);
Route::post('/api/templateInfo', [
    'as' => 'api.templateInfo',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@getTemplateInfo',
]);
Route::post('/api/updateUserForm', [
    'as' => 'api.updateUserForm',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@updateUserForm',
]);
Route::post('/api/addUserForm', [
    'as' => 'api.addUserForm',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@addUserForm',
]);

Route::post('/api/userCategoryInfo', [
    'as' => 'api.userCategoryInfo',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@getUserCategoryInfo',
]);
Route::post('/api/userCatFormInfo', [
    'as' => 'api.userCatFormInfo',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@getUserCatFormInfo',
]);
Route::post('/api/updateUserCatForm', [
    'as' => 'api.updateUserCatForm',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@updateUserCatForm',
]);
Route::post('/api/updateFormStatus', [
    'as' => 'api.updateFormStatus',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@updateFormStatus',
]);
Route::post('/api/userFormInfo', [
    'as' => 'api.userFormInfo',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@getUserFormInfo',
]);
Route::post('/api/userFormCount', [
    'as' => 'api.userFormCount',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@getUserFormCount',
]);

Route::post('/api/scanTemplate', [
    'as' => 'api.scanTemplate',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@scanTemplate',
]);

Route::post('/api/logout', [
    'as' => 'api.logout',
    'middleware' => 'checkAuth',
    'uses' => 'api\LoginController@logout',
]);

Route::post('/api/groupInfo', [
    'as' => 'api.groupInfo',
    'middleware' => 'checkAuth',
    'uses' => 'api\UserController@getGroupInfo',
]);
Route::post('/api/userInfo', [
    'as' => 'api.userInfo',
    'middleware' => 'checkAuth',
    'uses' => 'api\UserController@getUserInfo',
]);
Route::post('/api/assignUserForm', [
    'as' => 'api.assignUserForm',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@assignUserForm',
]);
Route::post('/api/acceptUserForm', [
    'as' => 'api.acceptUserForm',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@acceptUserForm',
]);
Route::post('/api/returnUserForm', [
    'as' => 'api.returnUserForm',
    'middleware' => 'checkAuth',
    'uses' => 'api\FormController@returnUserForm',
]);
Route::post('/api/notificationCount', [
    'as' => 'api.notificationCount',
    'middleware' => 'checkAuth',
    'uses' => 'api\NotificationController@notificationCount',
]);
Route::post('/api/notificationList', [
    'as' => 'api.notificationList',
    'middleware' => 'checkAuth',
    'uses' => 'api\NotificationController@notificationList',
]);
Route::post('/api/updateNotification', [
    'as' => 'api.updateNotification',
    'middleware' => 'checkAuth',
    'uses' => 'api\NotificationController@updateNotification',
]);