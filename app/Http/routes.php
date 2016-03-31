<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
| permissions variables: read, create, update, delete
*/

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/', function () {
        return view('welcome');
    });

    Route::group(['prefix' => 'logs', 'middleware' => ['role:admin', 'acl:read']], function () {

        Route::get('/', [
            'uses' => 'LogController@logList'
        ]);

        Route::get('view/{id}', [
            'uses' => 'LogController@index'
        ]);

        Route::group(['before' => 'csrf'], function () {

            Route::post('delete', [
                'middleware' => ['acl:delete'],
                'uses' => 'LogController@delete'
            ]);

            Route::post('deleteAll', [
                'middleware' => ['acl:delete'],
                'uses' => 'LogController@deleteAll'
            ]);

        });

    });

    Route::group(['prefix' => 'products', 'middleware' => ['acl:read']], function () {

        Route::get('/', [
            'uses' => 'ProductController@productList'
        ]);

        Route::get('/category/{category_id}', [
            'uses' => 'ProductController@productListByCategory'
        ]);

        Route::get('view/{id}', [
            'uses' => 'ProductController@index'
        ]);


        Route::get('subscribe/{id}', [
            'uses' => 'UsersSubscriptionsController@productSubscribe'
        ]);

        Route::get('unsubscribe/{id}', [
            'uses' => 'UsersSubscriptionsController@productUnsubscribe'
        ]);

        Route::group(['before' => 'csrf'], function () {

            Route::any('create', [
                'middleware' => ['acl:create'],
                'uses' => 'ProductController@create'
            ]);

            Route::any('update/{id}', [
                'middleware' => ['acl:update'],
                'uses' => 'ProductController@update'
            ]);

            Route::post('delete/{id}', [
                'middleware' => ['acl:delete'],
                'uses' => 'ProductController@delete'
            ]);

        });

    });

    Route::group(['prefix' => 'subscriptions', 'middleware' => ['acl:read']], function () {

        Route::get('/', [
            'uses' => 'SubscriptionController@subscriptionList'
        ]);

        Route::get('view/{id}', [
            'uses' => 'SubscriptionController@index'
        ]);

        Route::any('subscribe/{id}', [
            'uses' => 'UsersSubscriptionsController@subscribe'
        ]);

        Route::any('unsubscribe/{id}', [
            'uses' => 'UsersSubscriptionsController@unsubscribe'
        ]);

        Route::any('remove/{id}', [
            'uses' => 'UsersSubscriptionsController@unsubscribe'
        ]);

        Route::group(['before' => 'csrf'], function () {

            Route::any('create', [
                'middleware' => ['acl:create'],
                'uses' => 'SubscriptionController@create'
            ]);

            Route::any('update/{id}', [
                'middleware' => ['acl:update'],
                'uses' => 'SubscriptionController@update'
            ]);

            Route::post('delete/{id}', [
                'middleware' => ['acl:delete'],
                'uses' => 'SubscriptionController@delete'
            ]);

        });

    });

    Route::group(['prefix' => 'mysubscriptions', 'middleware' => ['acl:read']], function () {

        Route::get('/', [
            'uses' => 'UsersSubscriptionsController@mySubscriptionsList'
        ]);

        Route::get('view/{id}', [
            'uses' => 'UsersSubscriptionsController@index'
        ]);

        Route::any('resume/{id}', [
            'uses' => 'UsersSubscriptionsController@subscribe'
        ]);

    });

    Route::group(['prefix' => 'categories', 'middleware' => ['acl:read']], function () {

        Route::get('/', [
            'uses' => 'CategoryController@categoriesList'
        ]);

        Route::get('view/{id}', [
            'uses' => 'CategoryController@index'
        ]);

        Route::get('subscribe/{id}', [
            'uses' => 'UsersSubscriptionsController@categorySubscribe'
        ]);

        Route::get('unsubscribe/{id}', [
            'uses' => 'UsersSubscriptionsController@categoryUnsubscribe'
        ]);

        Route::group(['before' => 'csrf'], function () {

            Route::any('create', [
                'middleware' => ['acl:create'],
                'uses' => 'CategoryController@create'
            ]);

            Route::any('update/{id}', [
                'middleware' => ['acl:update'],
                'uses' => 'CategoryController@update'
            ]);

            Route::post('delete/{id}', [
                'middleware' => ['acl:delete'],
                'uses' => 'CategoryController@delete'
            ]);

        });

    });

    Route::group(['prefix' => 'users', 'middleware' => ['acl:read']], function () {

        Route::get('/', [
            'uses' => 'UserController@userList'
        ]);

        Route::get('view/{id}', [
            'uses' => 'UserController@index'
        ]);

        Route::group(['before' => 'csrf'], function () {

            Route::any('create', [
                'middleware' => ['acl:create'],
                'uses' => 'UserController@create'
            ]);

            Route::any('update/{id}', [
                'middleware' => ['acl:update'],
                'uses' => 'UserController@update'
            ]);

            Route::post('delete/{id}', [
                'middleware' => ['acl:delete'],
                'uses' => 'UserController@delete'
            ]);

        });

    });

});
