<?php

namespace Modules\Doctor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Doctor\Entities\doctor;
use Illuminate\Support\Facades\Input;

class doctorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $doctor = doctor::join('users', 'doctors.user_id', '=', 'users.id')
                ->join('doctor_categories', 'doctors.doctor_category_id', '=', 'doctor_categories.id')
                ->select('users.name as doctorName', 'email', 'phone', 'nik', 'doctor_categories.name as Speciality')
                ->paginate(5);
        
            return response()->json([
                "result" => $doctor
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something wrong",
                "data" => Null
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('doctor::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $doctor = new Doctor;
            $doctor->user_id = $request->user_id;
            $doctor->doctor_category_id = $request->doctor_category_id;
            $doctor->save();

            $doctors = doctor::join('users', 'doctors.user_id', '=', 'users.id')->where('user_id', '=', $request->user_id)
                ->join('doctor_categories', 'doctors.doctor_category_id', '=', 'doctor_categories.id')->where('doctor_category_id', '=', $request->doctor_category_id)
                ->select('users.name as doctorName', 'email', 'phone', 'nik', 'doctor_categories.name as Speciality')->get(); 
            return response()->json([
                "Message" => "Doctor successfully Added",
                "doctor" => $doctors
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something wrong",
                "data" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('doctor::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('doctor::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {

        try {
            $doctor = doctor::find($id);
            $doctor->delete();
            $doctor->save();
                return response()->json([
                    "Message" => "Doctor successfully Deleted",
                    "data" => $doctor
                ], 200);
        } catch (\Throwable $th) {
                return response()->json([
                    "Message" => "Something wrong",
                    "doctor" => null
                ], 400);
        }
         
    }
}
