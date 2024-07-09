<?php

namespace App\Repository\doctor_dashboard;

use App\Models\Diagnostic;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;

class DiagonisisRepository implements \App\Interfaces\doctor_dashboard\DiagonisisRepositoryInterface
{
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $this->invoice_status($request->invoice_id, 3);
            $diagnoisis = new Diagnostic();
            $diagnoisis->date = date('Y-m-d');
            $diagnoisis->diagnosis = $request->diagnosis;
            $diagnoisis->medicine = $request->medicine;
            $diagnoisis->invoice_id = $request->invoice_id;
            $diagnoisis->patient_id = $request->patient_id;
            $diagnoisis->doctor_id = $request->doctor_id;
            $diagnoisis->save();

            DB::commit();
            session()->flash('add');
            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $patient_records = Diagnostic::where('patient_id', $id)->get();
        return view('Dashboard.Doctor.invoices.patient_record', compact('patient_records'));
    }

    public function addReview($request)
    {
        DB::beginTransaction();
        try {
            $this->invoice_status($request->invoice_id, 2);
            $diagnoisis = new Diagnostic();
            $diagnoisis->date = date('Y-m-d');
            $diagnoisis->review_date = date('Y-m-d H:i:s');
            $diagnoisis->diagnosis = $request->diagnosis;
            $diagnoisis->medicine = $request->medicine;
            $diagnoisis->invoice_id = $request->invoice_id;
            $diagnoisis->patient_id = $request->patient_id;
            $diagnoisis->doctor_id = $request->doctor_id;
            $diagnoisis->save();

            DB::commit();
            session()->flash('add');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function invoice_status($invoice_id, $id_status)
    {

        $invoice_status = Invoice::findOrFail($invoice_id);

        $invoice_status->update([
            'invoice_status' => $id_status,
        ]);
    }


}
