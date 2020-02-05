<?php

use Illuminate\Database\Seeder;
use Modules\Doctor\Entities\doctor;

class doctor_categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $category = new doctor;
        $category->user_id = 2;
        $category->doctor_category_id = 1;
        $category->save();
    }
}
