<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class rolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Role Doctor
         $doctorRole = new Role;
         $doctorRole->name = "doctor";
         $doctorRole->description = "Doctor can make schedule and do thing that doctor do";
         $doctorRole->save();
 
         // Role Patient
         $patientRole = new Role;
         $patientRole->name = "patient";
         $patientRole->description = "Patient can make queue and do thing that patient can do";
         $patientRole->save();
 
         // Patient User
         $patient = new User;
         $patient->name = "Alan Sekha";
         $patient->email = "alansekha1905@gmail.com";
         $patient->password = bcrypt("rahasia");
         $patient->phone = "+62877322132";
         $patient->nik = 2132123123;
         $patient->save();
         $patient->attachRole($patientRole);
 
         // Doctor User
         $patient = new User;
         $patient->name = "Alan Yogastra";
         $patient->email = "alangates@gmail.com";
         $patient->password = bcrypt("rahasia");
         $patient->phone = "+62877322132";
         $patient->nik = 2132123123;
         $patient->save();
         $patient->attachRole($doctorRole);

         // Doctor User
         $patient = new User;
         $patient->name = "Novan Ashliq";
         $patient->email = "novan@gmail.com";
         $patient->password = bcrypt("rahasia");
         $patient->phone = "+62877322132";
         $patient->nik = 2132123123;
         $patient->save();
         $patient->attachRole($doctorRole);
    }
}
