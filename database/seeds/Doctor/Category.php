<?php

use Illuminate\Database\Seeder;
use Modules\Doctor\Entities\doctor_category;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new doctor_category;
        $category->name = "Spesialis Jantung";
        $category->save();
    }
}
