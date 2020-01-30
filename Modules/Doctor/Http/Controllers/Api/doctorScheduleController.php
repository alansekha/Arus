<?php

namespace Modules\Doctor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Doctor\Entities\doctor_schedule;

class doctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {
            $schedule = doctor_schedule::join('doctors', 'doctor_schedules.doctor_id', '=', 'doctors.id')
            ->join('users', 'doctors.user_id', '=', 'users.id')
            ->join('doctor_categories', 'doctors.doctor_category_id', '=', 'doctor_categories.id')
            ->select('name', 'phone', 'speciality_name','day', 'time')
            ->get();
            return response()->json([
                'message' => 'Here you got',
                'data' => $schedule
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something wrong',
                'data' => Null
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
            $schedule = new doctor_schedule;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = $request->day;
            $schedule->time = $request->time;
            $schedule->save();

            $schedules = doctor_schedule::join('doctors', 'doctor_schedules.doctor_id', '=', 'doctors.id') -> where('doctor_id', '=', $request->doctor_id)
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->join('doctor_categories', 'doctors.doctor_category_id', '=', 'doctor_categories.id')
                ->select('name', 'phone', 'speciality_name','day', 'time')
                ->get();

            return response()->json([
                'message' => 'Here you got',
                'data' => $schedules
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something wrong',
                'data' => Null
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
        // 
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        // 
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
            $schedule = doctor_schedule::find($id);
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = $request->day;
            $schedule->time = $request->time;
            $schedule->save();

            $schedules = doctor_schedule::join('doctors', 'doctor_schedules.doctor_id', '=', 'doctors.id') -> where('doctor_id', '=', $request->doctor_id)
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->join('doctor_categories', 'doctors.doctor_category_id', '=', 'doctor_categories.id')
                ->select('name', 'phone', 'speciality_name','day', 'time')
                ->get();

            return response()->json([
                'message' => 'Here you got',
                'data' => $schedules
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something wrong',
                'data' => Null
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
            $schedule = doctor_schedule::find($id);
            $schedule->delete();
            $schedule->save();

            return response()->json([
                'message' => 'Success Delete',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something wrong',
                'data' => Null
            ], 400);
        }
    }
}
