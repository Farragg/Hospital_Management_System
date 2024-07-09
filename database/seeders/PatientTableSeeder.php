<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Patients = new Patient();
        $Patients->email = 'patient@yahoo.com';
        $Patients->password = Hash::make('123456789');
        $Patients->Date_Birth = '2000-11-30';
        $Patients->Phone = '12345678';
        $Patients->Gender = 1;
        $Patients->Blood_Group= 'A+';
        $Patients->save();

        //save trans
        $Patients->name = 'أحمد';
        $Patients->Address = 'القاهرة';
        $Patients->save();
    }
}
