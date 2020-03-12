<?php

/*\\
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
        return redirect()->route('dashboard');
    })->name('home');


    // Change Password
    Route::get('password-change', 'Admin\DashboardController@showResetForm')->name('password.change');
    Route::post('password-update', 'Admin\DashboardController@updatepassword')->name('update.password');

    Auth::routes([
        'register' => false,
    ]);

    Route::group(['middleware' => ['auth:web']], function () {
        Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
        Route::POST('/manager/history/search', 'Admin\DashboardController@managerSearchTotalHistory');
        Route::POST('/manager/deposit/search', 'Admin\DashboardController@managerSearchDeposit');
        Route::POST('/manager/cost/search', 'Admin\DashboardController@managerSearchCost');

        Route::group(['middleware' => ['role:web']], function () {

            Route::group(['prefix' => 'admin'], function () {

                //Manager Routes
                Route::resource('manager', 'Admin\ManagerCrudController');
                Route::resource('manager', 'Admin\ManagerCrudController')->except(['show']);
                Route::get('/createBalance/{id}', 'Admin\ManagerCrudController@balance');
                Route::POST('/balance-add', 'Admin\ManagerCrudController@addBalance')->name('manager.balanceAdd');
                Route::post('/manager-enable/{id}', 'Admin\ManagerCrudController@managerEnable')->name('manager.enable');
                Route::post('/manager-disable/{id}', 'Admin\ManagerCrudController@managerDisable')->name('manager.disable');

            });
        });
        Route::POST('/manager/search', 'Admin\ManagerCrudController@searchManager');

        Route::POST('/history/search', 'Admin\ManagerCrudController@searchTotalHistory');
        Route::POST('/deposit/search', 'Admin\ManagerCrudController@searchDeposit');
        Route::POST('/cost/search', 'Admin\ManagerCrudController@searchCost');
        Route::resource('manager', 'Admin\ManagerCrudController')->only (['show']);

        Route::group(['prefix' => 'category'], function () {

            // Category Routes
            Route::get('/', 'Admin\CategoryController@index')->name('category.index');
            Route::get('/create', 'Admin\CategoryController@create')->name('category.create');
            Route::post('/store', 'Admin\CategoryController@store')->name('category.store');
            Route::get('/show/{id}', 'Admin\CategoryController@show')->name('category.show');
            Route::get('/edit/{id}', 'Admin\CategoryController@edit')->name('category.edit');
            Route::POST('/update/{id}', 'Admin\CategoryController@update')->name('category.update');
            Route::GET('/destroy/{id}', 'Admin\CategoryController@destroy')->name('category.destroy');

            Route::POST('/page/search', 'Admin\CategoryController@searchCategoryPage');
        });
            // Cost Routes
        Route::resource('cost', 'Admin\CostController');
        Route::POST('/cost/page/search', 'Admin\CostController@searchCostPage');

            // Deposit Routes
        Route::resource('deposit', 'Admin\ManagerDepositController');
        Route::POST('/deposit/page/search', 'Admin\ManagerDepositController@searchDepositPage');
        Route::GET('/depo/destroy/{id}', 'Admin\ManagerCrudController@depoDestroy');
    });

