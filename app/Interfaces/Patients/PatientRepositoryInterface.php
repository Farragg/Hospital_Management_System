<?php

namespace App\Interfaces\Patients;

interface PatientRepositoryInterface
{
    public function index();
    public function show($id);

    public function create();
    public function strore($request);

    public function edit($id);

    public function update($request);

    public function destroy($request);
}
