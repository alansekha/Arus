<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

route::group(['prefix'=>'doctor'], function(){
    route::resource('doctor_category', 'Api\DoctorCategoryController');
    route::resource('doctor_speciality', 'Api\doctorController');
    route::resource('doctor_schedule', 'Api\doctorScheduleController');
});

route::group(['prefix'=>'patient'], function(){
    route::resource('patient_family', 'Api\DoctorCategoryController');
});
