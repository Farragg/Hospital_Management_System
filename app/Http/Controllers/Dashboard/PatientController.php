<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Interfaces\Patients\PatientRepositoryInterface;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $Patient;

    public function __construct(PatientRepositoryInterface $Patient)
    {
        $this->Patient =$Patient;
    }

    public function index()
    {
        return $this->Patient->index();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return $this->Patient->create();
    }

    public function show(string $id)
    {
        return $this->Patient->show($id);
    }
    public function store(StorePatientRequest $request)
    {
        return $this->Patient->strore($request);
    }

    public function edit(string $id)
    {
        return $this->Patient->edit($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePatientRequest $request)
    {
        return $this->Patient->update($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->Patient->destroy($request);
    }
}
