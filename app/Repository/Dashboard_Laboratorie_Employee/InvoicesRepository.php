<?php

namespace App\Repository\Dashboard_Laboratorie_Employee;

use App\Interfaces\Dashboard_Laboratorie_Employee\InvoicesRepositoryInterface;
use App\Models\Laboratorie;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;

class InvoicesRepository implements InvoicesRepositoryInterface
{

    use UploadTrait;

    public function index()
    {
        $invoices= Laboratorie::where('case',0)->get();
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.index', compact('invoices'));
    }

    public function completed_invoices()
    {
        $invoices = Laboratorie::where('case',1)->where('employee_id',auth()->user()->id)->get();
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.completed_invoices',compact('invoices'));
    }

    public function edit($id)
    {
        $invoice= Laboratorie::findOrFail($id);
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.add_diagnosis', compact('invoice'));
    }

    public function update($request, $id)
    {

        DB::beginTransaction();
        try{

            $invoice = Laboratorie::findOrFail($id);

            $invoice->update([
                'employee_id'=> auth()->user()->id,
                'description_employee'=> $request->description_employee,
                'case'=> 1,
            ]);

            if( $request->hasFile('photos' )){

                foreach ( $request->photos as $photo){

                    $this->verifyAndStoreImageForeach($photo, 'laboratories', 'upload_image', $invoice->id, 'App\Models\Laboratorie');
                }
            }
            DB::commit();
            session()->flash('edit');
            return redirect()->route('invoices_laboratorie_employee.index');
        }catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }

    public function view_laboratories($id)
    {
        $laboratorie= Laboratorie::findOrFail($id);
        if($laboratorie->employee_id !=auth()->user()->id){

            return redirect()->route('404');
        }
        return view('Dashboard.dashboard_LaboratorieEmployee.invoices.patient_details', compact('laboratorie'));
    }
}
