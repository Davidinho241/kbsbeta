<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\TenantController;

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
Route::get('/', function () { return view('home'); });


Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::post('register', [RegisterController::class,'register']);

Route::get('password/forget',  function () {
	return view('pages.forgot-password');
})->name('password.forget');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');


Route::group(['middleware' => 'auth'], function(){
	// logout route
	Route::get('/logout', [LoginController::class,'logout']);
	Route::get('/clear-cache', [HomeController::class,'clearCache']);

	// dashboard route
	Route::get('/dashboard', function () {
		return view('pages.dashboard');
	})->name('dashboard');

	//only those have manage_user permission will get access
	Route::group(['middleware' => 'can:manage_user'], function(){
	    Route::get('/users', [UserController::class,'index']);
	    Route::get('/user/get-list', [UserController::class,'getUserList']);
		Route::get('/user/create', [UserController::class,'create']);
		Route::post('/user/create', [UserController::class,'store'])->name('create-user');
		Route::get('/user/{id}', [UserController::class,'edit']);
		Route::post('/user/update', [UserController::class,'update']);
		Route::get('/user/delete/{id}', [UserController::class,'delete']);
	});

	//only those have manage_role permission will get access
	Route::group(['middleware' => 'can:manage_role|manage_user'], function(){
		Route::get('/roles', [RolesController::class,'index']);
		Route::get('/role/get-list', [RolesController::class,'getRoleList']);
		Route::post('/role/create', [RolesController::class,'create']);
		Route::get('/role/edit/{id}', [RolesController::class,'edit']);
		Route::post('/role/update', [RolesController::class,'update']);
		Route::get('/role/delete/{id}', [RolesController::class,'delete']);
	});

	//only those have manage_permission permission will get access
	Route::group(['middleware' => 'can:manage_permission|manage_user'], function(){
		Route::get('/permission', [PermissionController::class,'index']);
		Route::get('/permission/get-list', [PermissionController::class,'getPermissionList']);
		Route::post('/permission/create', [PermissionController::class,'create']);
		Route::get('/permission/update', [PermissionController::class,'update']);
		Route::get('/permission/delete/{id}', [PermissionController::class,'delete']);
	});

	// get permissions
	Route::get('get-role-permissions-badge', [PermissionController::class,'getPermissionBadgeByRole']);


	// permission examples
    Route::get('/permission-example', function () {
    	return view('permission-example');
    });
    // API Documentation
    Route::get('/rest-api', function () { return view('api'); });
    // Editable Datatable
	Route::get('/table-datatable-edit', function () {
		return view('pages.datatable-editable');
	});

    // Themekit demo pages
	Route::get('/calendar', function () { return view('pages.calendar'); });
	Route::get('/charts-amcharts', function () { return view('pages.charts-amcharts'); });
	Route::get('/charts-chartist', function () { return view('pages.charts-chartist'); });
	Route::get('/charts-flot', function () { return view('pages.charts-flot'); });
	Route::get('/charts-knob', function () { return view('pages.charts-knob'); });
	Route::get('/forgot-password', function () { return view('pages.forgot-password'); });
	Route::get('/form-addon', function () { return view('pages.form-addon'); });
	Route::get('/form-advance', function () { return view('pages.form-advance'); });
	Route::get('/form-components', function () { return view('pages.form-components'); });
	Route::get('/form-picker', function () { return view('pages.form-picker'); });
	Route::get('/invoice', function () { return view('pages.invoice'); });
	Route::get('/layout-edit-item', function () { return view('pages.layout-edit-item'); });
	Route::get('/layouts', function () { return view('pages.layouts'); });

	Route::get('/navbar', function () { return view('pages.navbar'); });
	Route::get('/profile', function () { return view('pages.profile'); });
	Route::get('/project', function () { return view('pages.project'); });
	Route::get('/view', function () { return view('pages.view'); });

	Route::get('/table-bootstrap', function () { return view('pages.table-bootstrap'); });
	Route::get('/table-datatable', function () { return view('pages.table-datatable'); });
	Route::get('/taskboard', function () { return view('pages.taskboard'); });
	Route::get('/widget-chart', function () { return view('pages.widget-chart'); });
	Route::get('/widget-data', function () { return view('pages.widget-data'); });
	Route::get('/widget-statistic', function () { return view('pages.widget-statistic'); });
	Route::get('/widgets', function () { return view('pages.widgets'); });

	// themekit ui pages
	Route::get('/alerts', function () { return view('pages.ui.alerts'); });
	Route::get('/badges', function () { return view('pages.ui.badges'); });
	Route::get('/buttons', function () { return view('pages.ui.buttons'); });
	Route::get('/cards', function () { return view('pages.ui.cards'); });
	Route::get('/carousel', function () { return view('pages.ui.carousel'); });
	Route::get('/icons', function () { return view('pages.ui.icons'); });
	Route::get('/modals', function () { return view('pages.ui.modals'); });
	Route::get('/navigation', function () { return view('pages.ui.navigation'); });
	Route::get('/notifications', function () { return view('pages.ui.notifications'); });
	Route::get('/range-slider', function () { return view('pages.ui.range-slider'); });
	Route::get('/rating', function () { return view('pages.ui.rating'); });
	Route::get('/session-timeout', function () { return view('pages.ui.session-timeout'); });
	Route::get('/pricing', function () { return view('pages.pricing'); });



    //only those have manage_user permission will get access
    Route::group(['middleware' => 'can:manage_user'], function(){

        // All tenants routes
        Route::get('/tenants', [TenantController::class,'index']);
        Route::get('/tenant/get-list', [TenantController::class,'getTenantList']);
        Route::get('/tenant/create', [TenantController::class,'create']);
        Route::post('/tenant/store', [TenantController::class,'store'])->name('create-tenant');
        Route::get('/tenant/{uuid}', [TenantController::class,'edit']);
        Route::get('/tenant/settings/{uuid}', [TenantController::class,'settings']);
        Route::post('/tenant/update', [TenantController::class,'update'])->name('tenant-update');
        Route::get('/tenant/delete/{uuid}', [TenantController::class,'delete']);
        Route::get('/tenant/destroy/{uuid}', [TenantController::class,'destroy']);
        Route::get('/tenant/trashed', [TenantController::class,'getTenantTrashedList']);

        // All services routes
        Route::post('/tenant/service/store', [ServiceController::class,'store'])->name('create-service');
        Route::post('/tenant/service/update', [ServiceController::class,'update'])->name('update-service');
        Route::get('/tenant/service/get-list/{tenant_uuid}', [ServiceController::class,'getServiceList']);
        Route::get('/tenant/service/delete/{uuid}', [ServiceController::class,'delete']);
        Route::get('/tenant/service/destroy/{uuid}', [ServiceController::class,'destroy']);
        Route::get('/tenant/service/{uuid}', [ServiceController::class,'show']);


        // All categories routes
        Route::get('/category', [CategoryController::class,'index']);
        Route::post('/category/store', [CategoryController::class,'store'])->name('create-category');
        Route::post('/category/update', [CategoryController::class,'update'])->name('update-category');
        Route::get('/category/delete/{id}', [CategoryController::class,'delete']);
        Route::get('/category/destroy/{id}', [CategoryController::class,'destroy']);

        // All products routes
        Route::get('/products/create/{tenant_uuid}', [ProductController::class,'create']);
        Route::get('/products/update/{id}/{tenant_uuid}', [ProductController::class,'edit']);
        Route::get('/products/get-list/{service_uuid}', [ProductController::class,'getProductList']);
        Route::post('/products/store', [ProductController::class,'store'])->name('create-product');
        Route::post('/products/update', [ProductController::class,'update'])->name('update-product');
        Route::get('/products/delete/{id}', [ProductController::class,'delete']);
        Route::get('/products/destroy/{id}', [ProductController::class,'destroy']);

        // All plans routes
        Route::get('/plans', [PlanController::class,'index']);
    });

	// new inventory routes
	Route::get('/pos', function () { return view('tenant.pos'); });
	Route::get('/categories', function () { return view('tenant.category.index'); });
	Route::get('/sales', function () { return view('tenant.invoice.list'); });
	Route::get('/sales/create', function () { return view('tenant.invoice.create'); });
	Route::get('/purchases', function () { return view('tenant.transaction.list'); });
	Route::get('/purchases/create', function () { return view('tenant.transaction.create'); });
	Route::get('/customers', function () { return view('tenant.people.customers'); });
	Route::get('/suppliers', function () { return view('tenant.people.suppliers'); });

});


Route::get('/register', function () { return view('pages.register'); });
Route::get('/login-1', function () { return view('pages.login'); });
