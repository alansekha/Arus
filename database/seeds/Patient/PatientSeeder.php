<?php

use Illuminate\Database\Seeder;
use Modules\Patient\Entities\patient_family_member;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patient_family = new patient_family_member;
        $patient_family->user_id = 1;
        $patient_family->name = "Rayhan";
        $patient_family->nik = 3213123123;
        $patient_family->gender = "male";
        $patient_family->date_of_birth = '2002-05-19';
        $patient_family->place_of_birth = "jakarta";
        $patient_family->save();
        
        #sample patient user
        $patient_family = new patient_family_member;
        $patient_family->user_id = 2;
        $patient_family->name = "Bank Jago";
        $patient_family->nik = 214412444;
        $patient_family->gender = "male";
        $patient_family->date_of_birth = '2002-03-01';
        $patient_family->place_of_birth = "Surabaya";
        $patient_family->save();

    }
}
