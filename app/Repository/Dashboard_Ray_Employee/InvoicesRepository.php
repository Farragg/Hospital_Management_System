<?php

namespace App\Repository\Dashboard_Ray_Employee;

use App\Models\Ray;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;

class InvoicesRepository implements \App\Interfaces\Dashboard_Ray_Employee\InvoicesRepositoryInterface
{

    use UploadTrait;

    public function index()
    {
        $invoices= Ray::where('case',0)->get();
        return view('Dashboard.dashboard_RayEmployee.invoices.index', compact('invoices'));
    }

    public function completed_invoices()
    {
        $invoices = Ray::where('case',1)->where('employee_id',auth()->user()->id)->get();
        return view('Dashboard.dashboard_RayEmployee.invoices.completed_invoices',compact('invoices'));
    }

    public function edit($id)
    {
        $invoice= Ray::findOrFail($id);
        return view('Dashboard.dashboard_RayEmployee.invoices.add_diagnosis', compact('invoice'));
    }

    public function update($request, $id)
    {

        DB::beginTransaction();
        try{

            $invoice = Ray::findOrFail($id);

            $invoice->update([
                'employee_id'=> auth()->user()->id,
                'description_employee'=> $request->description_employee,
                'case'=> 1,
            ]);

            if( $request->hasFile('photos' )){

                foreach ( $request->photos as $photo){

                    $this->verifyAndStoreImageForeach($photo, 'Rays', 'upload_image', $invoice->id, 'App\Models\Ray');
                }
            }
            DB::commit();
            session()->flash('edit');
            return redirect()->route('invoices_ray_employee.index');
        }catch (\Exception $e){
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }


    }

    public function view_rays($id)
    {
        $rays= Ray::findOrFail($id);
        if($rays->employee_id !=auth()->user()->id){

            return redirect()->route('404');
        }
        return view('Dashboard.dashboard_RayEmployee.invoices.patient_details', compact('rays'));
    }
}
