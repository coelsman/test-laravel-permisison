<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([
    'middleware' => 'auth',
    'prefix' => 'admin'
], function ($router) {
    $router->get('abc', function () {
        return view('admin.abc');
    });

    $router->get('add-role/{role}', function ($role) {
        $role = \Spatie\Permission\Models\Role::firstOrCreate(
            [
                'name' => $role
            ],
            [
                'name' => $role,
                'guard_name' => 'api'
            ]
        );

        $permission = \Spatie\Permission\Models\Permission::firstOrCreate(
            [
                'name' => 'customer.request-features'
            ],
            [
                'name' => 'customer.request-features',
                'guard_name' => 'api'
            ]
        );

        $permission->assignRole($role);
    });

    $router->get('users/assign-permissions', function () {
        $user = \App\Models\User::whereEmail('customer1@localhost.com')->first();

        $user->assignRole(\Spatie\Permission\Models\Role::whereName('customer')->first());
    });
});

Route::group([
    'middleware' => ['auth', 'role:customer'],
    'prefix' => 'customer'
], function ($router) {
    $router->get('features/request', function () {
        return 'YOU HAVE PERMISSION TO REQUEST FEATURE';
    });
});
