<?php

namespace Modules\Patient\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Patient\Entities\patient_family_member;


class patientFamilyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {
            $family_member = patient_family_member::join('users', 'patient_family_members.user_id', '=', 'users.id')
            ->select('users.name as trustee', 'email', 'phone','patient_family_members.name as patientName', 'patient_family_members.nik as patientNik', 'gender', 'date_of_birth', 'place_of_birth')
            ->paginate(5);
            return response()->json([
                "patient" => $family_member
            ], 200); 
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something wrong",
                "error" => $th->getMessage()
            ], 400); 
        }
    
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('patient::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $patient_family = new patient_family_member;
            $patient_family->user_id = $request->user_id;
            $patient_family->name = $request->patient_name;
            $patient_family->nik = $request->patient_nik;
            $patient_family->gender = $request->gender;
            $patient_family->date_of_birth = $request->date_of_birth;
            $patient_family->place_of_birth = $request->place_of_birth;
            $patient_family->save();

            $patient = patient_family_member::join('users', 'patient_family_members.user_id', '=', 'users.id')
            ->where('user_id', '=', $request->user_id)
            ->select('users.name as trustee', 'email', 'phone','patient_family_members.name as patientName', 'patient_family_members.nik as patientNik', 'gender', 'date_of_birth', 'place_of_birth')
            ->paginate(5);
            
            return response()->json([
                "message" => "Successfully Added",
                "data" => $patient
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th->getMessage()
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
        return view('patient::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('patient::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $patient_family = patient_family_member::find($id);
            $patient_family->user_id = $request->user_id;
            $patient_family->name = $request->patient_name;
            $patient_family->nik = $request->patient_nik;
            $patient_family->gender = $request->gender;
            $patient_family->date_of_birth = $request->date_of_birth;
            $patient_family->place_of_birth = $request->place_of_birth;
            $patient_family->save();
            
            $patient = patient_family_member::join('users', 'patient_family_members.user_id', '=', 'users.id')
            ->where('user_id', '=', $request->user_id)
            ->select('users.name as trustee', 'email', 'phone','patient_family_members.name as patientName', 'patient_family_members.nik as patientNik', 'gender', 'date_of_birth', 'place_of_birth')
            ->paginate(5);

            return response()->json([
                "message" => "Successfully Edited",
                "data" => $patient
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $patient_family = patient_family_member::find($id);
            $patient_family->delete();
            $patient_family->save();
            
            return response()->json([
                "message" => "Successfully Deleted",
                "data" => $patient_family
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something went wrong",
                "error" => $th->getMessage()
            ], 400);
        }
    }
}
