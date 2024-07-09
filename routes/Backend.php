<?php

use App\Http\Controllers\Dashboard\AmbulanceController;
use App\Http\Controllers\Dashboard\appointment\AppointmentController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\DoctorController;
use App\Http\Controllers\Dashboard\InsuranceController;
use App\Http\Controllers\Dashboard\LaboratorieEmployeeController;
use App\Http\Controllers\Dashboard\PatientController;
use App\Http\Controllers\Dashboard\PaymentAccountController;
use App\Http\Controllers\Dashboard\RayEmployeeController;
use App\Http\Controllers\Dashboard\ReceiptAccountController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\SingleServiceController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('Dashboard_Admin', [DashboardController::class, 'index']);

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
    //######################### dashboard user #################################
    Route::get('/dashboard/user', function () {
        return view('Dashboard.User.dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard.user');
    //######################### end dashboard user ##############################

    //######################### dashboard admin #################################
    Route::get('/dashboard/admin', function () {
        return view('Dashboard.Admin.dashboard');
    })->middleware(['auth:admin', 'verified'])->name('dashboard.admin');
    //######################### end dashboard admin #############################


    //######################### dashboard doctor #################################
    Route::get('/dashboard/doctor', function () {
        return view('Dashboard.doctor.dashboard');
    })->middleware(['auth:doctor', 'verified'])->name('dashboard.doctor');
    //######################### end dashboard doctor #############################



    Route::middleware(['auth:admin'])->group( function (){
        //######################### Section Route #############################
        Route::resource('Sections', SectionController::class);
        //######################### End Section Route #########################

        //######################### Doctor Route #############################
        Route::resource('Doctors', DoctorController::class);
        Route::post('update_password', [DoctorController::class, 'update_password'])->name('update_password');
        Route::post('update_status', [DoctorController::class, 'update_status'])->name('update_status');
        //######################### End Doctor Route #########################

        //######################### Services Route #############################
        Route::resource('Service', SingleServiceController::class);
        //######################### End Services Route #############################

        //######################### GroupServices Route #############################
        Route::view('Add_GroupServices', 'livewire.GroupServices.include_create')->name('Add_GroupServices');
        Livewire::setUpdateRoute( function ($handle){
            return Route::post('/livewire/update', $handle);
        });
        //######################### End GroupServices Route #############################

        //############################# insurance route ##########################################

        Route::resource('insurance', InsuranceController::class);

        //############################# End insurance route ######################################

        //############################# Ambulance route ##########################################

        Route::resource('Ambulance', AmbulanceController::class);

        //############################# End Ambulance route ######################################

        //############################# Patient route ##########################################

        Route::resource('Patients', PatientController::class);

        //############################# End Patient route ######################################

        //############################# Invoices route ##########################################

        Route::view('single_invoices', 'livewire.invoices.index')->name('single_invoices');
        Route::view('Print_single_invoices', 'livewire.invoices.print')->name('Print_single_invoices');

        //############################# End Invoices route ######################################

        //############################# Group Invoices route ##########################################

        Route::view('group_invoices', 'livewire.Group_invoices.index')->name('group_invoices');
        Route::view('group_Print_single_invoices', 'livewire.Group_invoices.print')->name('group_Print_single_invoices');

        //############################# Group Invoices route ######################################

        //############################# Receipt route ##########################################

        Route::resource('Receipt', ReceiptAccountController::class);

        //############################# End Receipt route ######################################

        //############################# Payment route ##########################################

        Route::resource('Payment', PaymentAccountController::class);

        //############################# End Payment route ######################################

        //############################# RayEmployee route ##########################################

        Route::resource('ray_employee', RayEmployeeController::class);

        //############################# End RayEmployee route ######################################

        //############################# laboratorie_employee route ##########################################

        Route::resource('laboratorie_employee', LaboratorieEmployeeController::class);

        //############################# End laboratorie_employee route ######################################

        //############################# Appointments route ##########################################

        Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::put('appointments/approval/{id}', [AppointmentController::class, 'approval'])->name('appointments.approval');
        Route::get('appointments/approval', [AppointmentController::class, 'index2'])->name('appointments.index2');
        Route::delete('appointments/destroy/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');

        //############################# End Appointments route ######################################

    });

    require __DIR__.'/auth.php';
});
