<?php

namespace App\Repository\Doctors;

use App\Interfaces\Doctors\DoctorRepositoryInterface;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Section;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class DoctorRepository implements DoctorRepositoryInterface
{
    use UploadTrait;

    public function index()
    {
        //$doctors = Doctor::all();
        $doctors = Doctor::with('doctorappointments')->get();
        return view('Dashboard.Doctors.index', compact('doctors'));
    }

    public function create()
    {
        $sections = Section::all();
        $appointments = Appointment::all();
        return view('Dashboard.Doctors.add', compact('sections', 'appointments'));
    }

    public function store($request)
    {
        //use transaction to prevent any unreliable data when u insert into two tables
        DB::beginTransaction();

        try {

            $doctors = new Doctor();
            $doctors->email = $request->email;
            $doctors->password = Hash::make($request->password);
            $doctors->section_id = $request->section_id;
            $doctors->phone = $request->phone;
            $doctors->status = 1;
            $doctors->save();
            // store trans
            $doctors->name = $request->name;
//            $doctors->appointments = implode(",", $request->appointments);
            $doctors->save();

            $doctors->doctorappointments()->attach($request->appointments);


            //Upload img
            $this->verifyAndStoreImage($request, 'photo', 'doctors', 'upload_image', $doctors->id, 'App\Models\Doctor');

            DB::commit();
            session()->flash('add');
            return redirect()->route('Doctors.create');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $sections = Section::all();
        $appointments = Appointment::all();
        $doctor = Doctor::findOrFail($id);
        return view('Dashboard.Doctors.edit', compact('sections', 'appointments', 'doctor'));
    }

    public function update($request)
    {
        DB::beginTransaction();

        try {

            $doctors = Doctor::findOrFail($request->id);
            $doctors->email = $request->email;
            $doctors->section_id = $request->section_id;
            $doctors->phone = $request->phone;
            $doctors->save();
            // store trans
            $doctors->name = $request->name;
            $doctors->save();

            //update pivot table
            $doctors->doctorappointments()->sync($request->appointments);

            // update photo
            if ($request->has('photo')) {
                // Delete old photo
                if ($doctors->image) {
                    $old_img = $doctors->image->filename;
                    $this->Delete_attachment('upload_image', 'doctors/' . $old_img, $request->id);
                }
                //Upload img
                $this->verifyAndStoreImage($request, 'photo', 'doctors', 'upload_image', $request->id, 'App\Models\Doctor');
            }

            DB::commit();
            session()->flash('edit');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update_password($request)
    {
        try{
            $doctor= Doctor::findOrFail($request->id);
            $doctor->update([
                'password' =>Hash::make($request->password),
            ]);

            session()->flash('edit');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update_status($request)
    {
        try{
            $doctor= Doctor::findOrfail($request->id);
            $doctor->update([
                'status' =>$request->status,
            ]);

            session()->flash('edit');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($request)
    {
        if ($request->page_id == 1) {

            if ($request->filename) {

                $this->Delete_attachment('upload_image', 'doctors/' . $request->filename, $request->id, $request->filename);
            }
            Doctor::destroy($request->id);
            session()->flash('delete');
            return redirect()->route('Doctors.index');
        } //---------------------------------------------------------------

        else {

            $delete_select_id = explode(",", $request->delete_select_id);

            foreach ($delete_select_id as $ids_doctors) {
                $doctor = Doctor::findOrFail($ids_doctors);
                if ($doctor->image) {
                    $this->Delete_attachment('upload_image', 'doctors/' . $doctor->image->filename, $ids_doctors, $doctor->image->filename);

                }
            }

            Doctor::destroy($delete_select_id);
            session()->flash('delete');
            return redirect()->route('Doctors.index');
        }
    }
}
