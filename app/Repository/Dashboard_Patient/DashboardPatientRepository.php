<?php

namespace App\Repository\Dashboard_Patient;

use App\Interfaces\Dashboard_Patient\DashboardPatientRepositoryInterface;
use App\Models\Invoice;
use App\Models\Laboratorie;
use App\Models\Ray;
use App\Models\ReceiptAccount;

class DashboardPatientRepository implements DashboardPatientRepositoryInterface
{

    public function invoices()
    {
        $invoices = Invoice::where('patient_id', auth()->user()->id)->get();
        return view('Dashboard.dashboard_patient.invoices', compact('invoices'));
    }

    public function laboratories()
    {
        $laboratories = Laboratorie::where('patient_id', auth()->user()->id)->get();
        return view('Dashboard.dashboard_patient.laboratories', compact('laboratories'));
    }

    public function viewLaboratories($id)
    {
        $laboratorie = Laboratorie::findOrFail($id);
        if($laboratorie->patient_id != auth()->user()->id){
            return redirect()->route('404');
        }

        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.patient_details', compact('laboratorie'));
    }

    public function rays()
    {
        $rays= Ray::where('patient_id', auth()->user()->id)->get();
        return view('Dashboard.dashboard_patient.rays', compact('rays'));
    }

    public function viewRays($id)
    {
        $rays = Ray::findOrFail($id);
        if($rays->patient_id != auth()->user()->id){
            return redirect()->route('404');
        }

        return view('Dashboard.dashboard_RayEmployee.invoices.patient_details', compact('rays'));
    }

    public function payments()
    {
        $payments = ReceiptAccount::where('patient_id', auth()->user()->id)->get();
        return view('Dashboard.dashboard_patient.payments', compact('payments'));
    }
}
