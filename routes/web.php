<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace' => 'Manage'], function() {

    

    Route::group(['prefix' => '/manage'], function() {

        Route::group(['middleware' => 'adminguest'], function(){
            /* LOGIN PAGE ROUTES */
            Route::get('/login',                                        'LoginController@login');
            Route::post('/login',                                       'LoginController@submit');
        });
        Route::group(['middleware' => 'adminauth'], function(){

            Route::get('/logout',                                       'LogoutController@logout');

            /* DEFAULT PAGE ROUTES */
            Route::get('',                                              'AdminController@index');
            Route::get('/dashboard',                                    'AdminController@index');

            /* PROFILE PAGES ROUTES */
            Route::get('/profile',                                      'AdminController@profile');
            Route::post('/profile',                                     'AdminController@submit');

            /* QUIZ PAGES ROUTES */
            Route::get('/quiz',                                         'QuizController@index');
            // Route::post('/quiz/load',                                'QuizController@load');
            Route::get('/quiz/create',                                  'QuizController@create');
            Route::get('/quiz/edit/{id}',                               'QuizController@edit');
            Route::get('/quiz/delete/{id}',                             'QuizController@delete');
            Route::put('/question/edit/{id}',                           'QuizController@update');
            Route::post('/question/add',                                'QuizController@addQuestion');
            Route::delete('/question/delete/{id}',                      'QuizController@deleteQuestion');
            // Route::get('/quiz/view/{id}',                            'QuizController@view');
            Route::post('/quiz/store',                                  'QuizController@store');
            // Route::post('/quiz/destroy',                             'QuizController@destroy');



            /* USERS PAGES ROUTES */
            Route::get('/users',                                        'UserController@index');
            Route::post('/users/load',                                  'UserController@load');
            Route::post('/users/destroy',                               'UserController@destroy');
            Route::get('/users/create',                                 'UserController@create');
            Route::get('/users/edit/{id}',                              'UserController@edit');
            Route::post('/users/store',                                 'UserController@store');


            /* DESIGNATION PAGES ROUTES */
            Route::get('/designations',                                  'DesignationController@index');
            Route::post('/designations/load',                            'DesignationController@load');
            Route::post('/designations/destroy',                         'DesignationController@destroy');
            Route::get('/designations/create',                           'DesignationController@create');
            Route::get('/designation/edit/{id}',                         'DesignationController@edit');
            Route::post('/designations/store',                           'DesignationController@store');

            /* PROJECT PAGES ROUTES */
            Route::get('/projects',                                      'ProjectController@index');
            Route::post('/projects/load',                                'ProjectController@load');
            Route::get('/projects/create',                               'ProjectController@create');
            Route::get('/projects/edit/{id}',                            'ProjectController@edit');
            Route::get('/projects/view/{id}',                            'ProjectController@view');
            Route::post('/projects/store',                               'ProjectController@store');
            Route::post('/projects/destroy',                             'ProjectController@destroy');

            Route::post('/projects/getmessages',                         'ProjectController@getmessages');
            Route::post('/projects/sendmessage',                         'ProjectController@sendmessage');
            Route::post('/projects/getmessage',                          'ProjectController@getmessage');
            Route::post('/projects/send-media-message',                  'ProjectController@sendmediamessage');

            /* PROJECT MEDIA PAGES ROUTES */
            Route::get('/project-media',                                  'MediaController@index');
            Route::post('/project-media/load',                            'MediaController@load');
            Route::get('/project-media/view/{id}',                        'MediaController@view');
            Route::get('/project-media/download/{id}',                    'MediaController@download');

            /* Client PAGES ROUTES */
            Route::get('/clients',                                      'ClientsController@index');
            Route::post('/clients/load',                                'ClientsController@load');


            /* PROJECT PAGES ROUTES */
            Route::get('/tasks',                                          'TaskController@index');
            Route::post('/tasks/load',                                    'TaskController@load');
            Route::get('/tasks/create',                                   'TaskController@create');
            Route::get('/tasks/edit/{id}',                                'TaskController@edit');
            Route::get('/tasks/view/{id}',                                'TaskController@view');
            Route::post('/tasks/store',                                   'TaskController@store');
            Route::post('/tasks/destroy',                                 'TaskController@destroy');
            Route::post('/tasks/status-update',                           'TaskController@statusupdate');
            Route::post('/tasks/order-update',                            'TaskController@orderupdate');

            /* DESIGNATION PAGES ROUTES */
            Route::get('/categories',                                     'CategoryController@index');
            Route::post('/categories/load',                               'CategoryController@load');
            Route::post('/categories/destroy',                            'CategoryController@destroy');
            Route::get('/categories/create',                              'CategoryController@create');
            Route::get('/categories/edit/{id}',                           'CategoryController@edit');
            Route::post('/categories/store',                              'CategoryController@store');
        });
    });

    Route::group(['prefix' => '/client'], function() {
        // Route::group(['middleware' => 'clientguest'], function(){
        //     /* LOGIN PAGE ROUTES */
        //     Route::get('/login',                                        'LoginController@login');
        //     Route::post('/login',                                       'LoginController@submit');
        // });
        Route::group(['middleware' => 'clientauth'], function(){

            Route::get('/logout',                                       'LogoutController@logout');

            /* DEFAULT PAGE ROUTES */
            Route::get('',                                              'AdminController@index');
            Route::get('/dashboard',                                    'AdminController@index');

            /* PROFILE PAGES ROUTES */
            Route::get('/profile',                                      'AdminController@profile');
            Route::post('/profile',                                     'AdminController@submit');

            /* PROJECT PAGES ROUTES */
            Route::get('/projects',                                      'ProjectController@index');
            Route::post('/projects/load',                                'ProjectController@load');
            Route::get('/projects/create',                               'ProjectController@create');
            Route::get('/projects/edit/{id}',                            'ProjectController@edit');
            Route::get('/projects/view/{id}',                            'ProjectController@view');
            Route::post('/projects/store',                               'ProjectController@store');
            Route::post('/projects/destroy',                             'ProjectController@destroy');

            Route::post('/projects/getmessages',                         'ProjectController@getmessages');
            Route::post('/projects/sendmessage',                         'ProjectController@sendmessage');

        });
    });

    Route::group(['prefix' => '/member'], function() {

        Route::group(['middleware' => 'memberauth'], function(){

            Route::get('/logout',                                       'LogoutController@logout');

            /* DEFAULT PAGE ROUTES */
            Route::get('',                                              'AdminController@index');
            Route::get('/dashboard',                                    'AdminController@index');

            /* PROFILE PAGES ROUTES */
            Route::get('/profile',                                      'AdminController@profile');
            Route::post('/profile',                                     'AdminController@submit');

            /* PROJECT PAGES ROUTES */
            Route::get('/projects',                                      'ProjectController@index');
            Route::post('/projects/load',                                'ProjectController@load');
            Route::get('/projects/create',                               'ProjectController@create');
            Route::get('/projects/edit/{id}',                            'ProjectController@edit');
            Route::get('/projects/view/{id}',                            'ProjectController@view');
            Route::post('/projects/store',                               'ProjectController@store');
            Route::post('/projects/destroy',                             'ProjectController@destroy');

            Route::post('/projects/getmessages',                         'ProjectController@getmessages');
            Route::post('/projects/sendmessage',                         'ProjectController@sendmessage');
        });
    });
});



Route::group(['namespace' => 'Front', 'prefix' => '/'], function() {

    // HOME
    Route::get('/',                                              'HomeController@index');

    //REGISTER
    Route::get('/register',                                      'RegisterController@index');
    Route::post('/register/client',                              'RegisterController@submit');
    Route::get('/otp-verify/{id}',                               'RegisterController@otpverify');
    Route::post('otp/verify',                                    'RegisterController@otpverifysubmit');

    Route::get('/login',                                         'LoginController@index');
    Route::post('login/client',                                  'LoginController@submit');


    Route::get('/dashboard',                                     'DashboardController@index');
    Route::post('/dashboard',                                     'DashboardController@submit');


});
