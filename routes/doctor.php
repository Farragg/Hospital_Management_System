<?php

use App\Http\Controllers\Dashbord_Doctor\DiagnosticController;
use App\Http\Controllers\Dashbord_Doctor\LaboratorieController;
use App\Http\Controllers\Dashbord_Doctor\PatientDetailsController;
use App\Http\Controllers\Dashbord_Doctor\RayController;
use App\Http\Controllers\doctor\InvoiceController;
use App\Livewire\Chat\Createchat;
use App\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Doctor Routes
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


    //######################### dashboard doctor #################################
    Route::get('/dashboard/doctor', function () {
        return view('Dashboard.doctor.dashboard');
    })->middleware(['auth:doctor', 'verified'])->name('dashboard.doctor');
    //######################### end dashboard doctor #############################



    Route::middleware(['auth:doctor'])->group( function (){

        Route::prefix('doctor')->group(function (){

            //############################# completed_invoices route ##########################################
            Route::get('completed_invoices', [InvoiceController::class,'completedInvoices'])->name('completedInvoices');
            //############################# end invoices route ################################################

            //############################# review_invoices route ##########################################
            Route::get('review_invoices', [InvoiceController::class,'reviewInvoices'])->name('reviewInvoices');
            //############################# end invoices route #############################################

            //######################### Invoice Route #############################
            Route::resource('invoices', InvoiceController::class);
            //######################### End Invoice Route #########################

            //############################# review_invoices route ##########################################
            Route::post('add_review', [DiagnosticController::class,'addReview'])->name('add_review');
            //############################# end invoices route #############################################

            //######################### Diagonstics Route #############################
            Route::resource('Diagnostics', DiagnosticController::class);
            //######################### End Diagonstics Route #########################

            //######################### Rays Route #############################
            Route::resource('rays', RayController::class);
            //######################### End Rays Route #########################

            //######################### Rays Route #############################
            Route::get('patient_details/{id}', [PatientDetailsController::class, 'index'])->name('patient_details');
            //######################### End Rays Route #########################

            //######################### Laboratories Route #############################
            Route::resource('Laboratories', LaboratorieController::class);
            Route::get('show_laboratorie/{id}', [InvoiceController::class, 'showLaboratorie'])->name('show.laboratorie');
            //######################### End Laboratories Route #########################

            //############################# Chat route ##########################################
            Route::get('list/patients', Createchat::class)->name('list.patients');
            Route::get('chat/patients', Main::class)->name('chat.patients');
            Livewire::setUpdateRoute( function ($handle){
                return Route::post('/livewire/update', $handle);
            });
            //############################# end Chat route ######################################
        });

        Route::get('404', function () {
            return view('Dashboard.404');
        })->name('404');

    });
    require __DIR__.'/auth.php';
});
