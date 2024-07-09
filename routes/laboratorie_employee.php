<?php


use App\Http\Controllers\Dashboard_Laboratorie_Employee\InvoiceController;
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


    //######################### dashboard laboratorie_employee #################################
    Route::get('/dashboard/laboratorie_employee', function () {
        return view('Dashboard.dashboard_LaboratorieEmployee.dashboard');
    })->middleware(['auth:laboratorie_employee', 'verified'])->name('dashboard.laboratorie_employee');
    //######################### end dashboard laboratorie_employee #############################

    Route::middleware(['auth:laboratorie_employee'])->group(function () {

        //############################# invoices route ##########################################
        Route::resource('invoices_laboratorie_employee', InvoiceController::class);
        Route::get('completed_invoices', [InvoiceController::class,'completed_invoices'])->name('completed_invoices');
        Route::get('view_laboratories/{id}', [InvoiceController::class,'view_laboratories'])->name('view_laboratories');
        //############################# end invoices route ######################################

    });


    require __DIR__.'/auth.php';
});
