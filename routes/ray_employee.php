<?php


use App\Http\Controllers\Dashboard_Ray_Employee\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ray_Employee Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){


    //######################### dashboard ray_employee #################################
    Route::get('/dashboard/ray_employee', function () {
        return view('Dashboard.dashboard_RayEmployee.dashboard');
    })->middleware(['auth:ray_employee', 'verified'])->name('dashboard.ray_employee');
    //######################### end dashboard ray_employee #############################

    Route::middleware(['auth:ray_employee'])->group(function () {

        //############################# invoices route ##########################################
        Route::resource('invoices_ray_employee', InvoiceController::class);
        Route::get('completed_invoices', [InvoiceController::class,'completed_invoices'])->name('completed_invoices');
        Route::get('view_rays/{id}', [InvoiceController::class,'viewRays'])->name('view_rays');
        //############################# end invoices route ######################################

    });


    require __DIR__.'/auth.php';
});
