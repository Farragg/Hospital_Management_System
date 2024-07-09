<?php


use App\Http\Controllers\Dashboard_Patient\PatientController;
use App\Livewire\Chat\Createchat;
use App\Livewire\Chat\Main;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Patient Routes
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

    //######################### dashboard patient #################################
    Route::get('/dashboard/patient', function () {
        return view('Dashboard.dashboard_patient.dashboard');
    })->middleware(['auth:patient', 'verified'])->name('dashboard.patient');
    //######################### end dashboard patient #############################

    Route::middleware(['auth:patient'])->group(function () {

        //############################# invoices route ##########################################
        Route::get('invoices', [PatientController::class, 'invoices'])->name('invoices.patient');
        Route::get('laboratories', [PatientController::class,'laboratories'])->name('laboratories.patient');
        Route::get('view_laboratories/{id}', [PatientController::class,'viewLaboratories'])->name('laboratories.view');
        Route::get('rays', [PatientController::class,'rays'])->name('rays.patient');
        Route::get('view_rays/{id}', [PatientController::class,'viewRays'])->name('rays.view');
        Route::get('payments', [PatientController::class,'payments'])->name('payments.patient');
        //############################# end invoices route ######################################

        //############################# Chat route ##########################################
        Route::get('list/doctors', Createchat::class)->name('list.doctors');
        Route::get('chat/doctors', Main::class)->name('chat.doctors');
        Livewire::setUpdateRoute( function ($handle){
            return Route::post('/livewire/update', $handle);
        });
        //############################# end Chat route ######################################
    });


    require __DIR__.'/auth.php';
});
