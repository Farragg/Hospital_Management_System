<?php

namespace App\Repository\RayEmployee;

use App\Interfaces\RayEmployee\RayEmployeeRepositoryInterface;
use App\Models\RayEmployee;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class RayEmployeeRepository implements RayEmployeeRepositoryInterface
{

    public function index()
    {
        $ray_employees = RayEmployee::all();
        return view('Dashboard.ray_employee.index', compact('ray_employees'));
    }

    public function store($request)
    {
        try{

            $ray_employee = new RayEmployee();
            $ray_employee->name = $request->name;
            $ray_employee->email = $request->email;
            $ray_employee->password = Hash::make($request->password);
            $ray_employee->save();

            session()->flash('add');
            return back();
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update($request, $id)
    {
        //get all request data
        $input = $request->all();

        // if its there hash the password (edit password)
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }
        else{

            // Helpers in laravel
            // means get all request except (ماعدا) password

            $input = Arr::except($input, ['password']);
        }

        // update all except password its empty !**
        $ray_employee = RayEmployee::find($id);
        $ray_employee->update($input);

        session()->flash('edit');
        return back();
    }

    public function destroy($id)
    {
        try{
            RayEmployee::destroy($id);

            session()->flash('delete');
            return redirect()->back();
        }catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
