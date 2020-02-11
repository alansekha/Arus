<?php

namespace Modules\Doctor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Doctor\Entities\doctor_schedule;
use Illuminate\Support\Facades\Validator;

class doctorScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $orderByType = $request->orderByType;
            $orderBy = $request->orderBy;

            if ($orderBy === null) {
                $orderBy = 'id';
            } 
            
            if($orderByType === null) {
                $orderByType = 'ASC';
            }

            
            $schedule = doctor_schedule::join('doctors', 'doctor_schedules.doctor_id', '=', 'doctors.id')
            ->join('users', 'doctors.user_id', '=', 'users.id')
            ->join('doctor_categories', 'doctors.doctor_category_id', '=', 'doctor_categories.id')
            ->where('users.name', 'like', "%{$request->search}%")
            ->orWhere('users.phone', 'like', "%{$request->search}%")
            ->orWhere('doctor_categories.name', 'like', "%{$request->search}%")
            ->orWhere('day', 'like', "%{$request->search}")
            ->orWhere('time', 'like', "%{$request->search}")
            ->orWhere('doctor_schedules.id', 'like', "%{$request->search}")
            ->select('doctor_schedules.id', 'users.name as doctorName', 'phone', 'doctor_categories.name as speciality','day', 'time')
            ->orderBy($orderBy, $orderByType)
            ->paginate(5);
            return response()->json([
                'message' => 'Here you got',
                'data' => $schedule
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something wrong',
                'data' => $th->getMessage()
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

            $messages = [
                'doctor_id.required' => 'You must input data',
                'day.required' => 'You must input data',
                'time.required' => 'You must input data',
                'doctor_id.numeric' => 'you just can add number',
                'day.numeric' => 'you just can add number',
                'time.date_format' => 'just add hour and minutes',
            ];

            $validator = Validator::make($request->all(), [
                'doctor_id' => 'required|numeric',
                'day' => 'required|numeric|max:255',
                'time' => 'required|date_format:H:i'
            ],$messages);

            if ($validator->fails()) {
                $this->data['message'] = 'error';
                $this->data['error'] = $validator->errors();
                return $this->data;
            }

            $schedule = new doctor_schedule;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = $request->day;
            $schedule->time = $request->time;
            $schedule->save();

            $schedules = doctor_schedule::join('doctors', 'doctor_schedules.doctor_id', '=', 'doctors.id') -> where('doctor_id', '=', $request->doctor_id)
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->join('doctor_categories', 'doctors.doctor_category_id', '=', 'doctor_categories.id')
                ->select('doctor_schedules.id', 'users.name as doctorName', 'phone', 'doctor_categories.name as speciality','day', 'time')
                ->get();

            return response()->json([
                'message' => 'Here you got',
                'data' => $schedules
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something wrong',
                'data' => $th->getMessage()
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
            
            $messages = [
                'doctor_id.required' => 'You must input data',
                'day.required' => 'You must input data',
                'time.required' => 'You must input data',
                'doctor_id.numeric' => 'you just can add number',
                'day.numeric' => 'you just can add number',
                'time.date_format' => 'just add hour and minutes',
            ];

            $validator = Validator::make($request->all(), [
                'doctor_id' => 'required|numeric',
                'day' => 'required|numeric|max:255',
                'time' => 'required|date_format:H:i'
            ],$messages);

            if ($validator->fails()) {
                $this->data['message'] = 'error';
                $this->data['error'] = $validator->errors();
                return $this->data;
            }

            $schedule = doctor_schedule::find($id);
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = $request->day;
            $schedule->time = $request->time;
            $schedule->save();

            $schedules = doctor_schedule::join('doctors', 'doctor_schedules.doctor_id', '=', 'doctors.id') -> where('doctor_id', '=', $request->doctor_id)
                ->join('users', 'doctors.user_id', '=', 'users.id')
                ->join('doctor_categories', 'doctors.doctor_category_id', '=', 'doctor_categories.id')
                ->select('users.name as doctorName', 'phone', 'doctor_categories.name as speciality','day', 'time')
                ->get();

            return response()->json([
                'message' => 'Here you got',
                'data' => $schedules
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something wrong',
                'data' => $th->getMessage()
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
                'data' => $schedule
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something wrong',
                'data' => $th->getMessage()
            ], 400);
        }
    }
}
