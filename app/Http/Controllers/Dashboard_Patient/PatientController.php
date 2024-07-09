<?php

namespace App\Http\Controllers\Dashboard_Patient;

use App\Http\Controllers\Controller;
use App\Interfaces\Dashboard_Patient\DashboardPatientRepositoryInterface;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private $patient;

    public function __construct(DashboardPatientRepositoryInterface $patient)
    {
        $this->patient = $patient;
    }

    public function invoices()
    {
        return $this->patient->invoices();
    }

    public function laboratories()
    {
        return $this->patient->laboratories();
    }

    public function viewLaboratories(string $id)
    {
        return $this->patient->viewLaboratories($id);
    }

    public function rays()
    {
        return $this->patient->rays();
    }

    public function viewRays(string $id)
    {
        return $this->patient->viewRays($id);
    }

    public function payments()
    {
        return $this->patient->payments();
    }
}
