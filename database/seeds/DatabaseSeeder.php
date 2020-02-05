<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(rolePermissionSeeder::class);
        $this->call(Category::class);
        $this->call(doctor_categories::class);
        $this->call(PatientSeeder::class);
    }
}
