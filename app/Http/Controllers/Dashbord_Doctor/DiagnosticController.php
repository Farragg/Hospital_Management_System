<?php

namespace App\Http\Controllers\Dashbord_Doctor;

use App\Http\Controllers\Controller;
use App\Interfaces\doctor_dashboard\DiagonisisRepositoryInterface;
use Illuminate\Http\Request;

class DiagnosticController extends Controller
{
    private $Diagnosis;

    public function __construct(DiagonisisRepositoryInterface $Diagnosis)
    {
        $this->Diagnosis = $Diagnosis;
    }

    public function index()
    {

    }

    public function addReview (Request $request)
    {
        return $this->Diagnosis->addReview($request);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->Diagnosis->store($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->Diagnosis->show($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
