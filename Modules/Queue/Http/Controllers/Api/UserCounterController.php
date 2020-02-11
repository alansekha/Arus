<?php

namespace Modules\Queue\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Queue\Entities\user_counter;
use DB;

class UserCounterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $counter = user_counter::join('users', 'user_counters.user_id', '=', 'users.id')
            ->join('counters', 'user_counters.counter_id', '=', 'counters.id')
            ->select('users.name as name', 'email', 'nik', 'counters.name as counterName', 'queue_number', 'is_processed', 'date')->orderBy($request->orderBy,  $request->orderByType)
            ->orderBy('queue_number', 'ASC')
            ->where('users.name', 'like', "%{$request->search}%")->orWhere('users.email', 'like', "%{$request->search}%")
            ->orWhere('users.nik', 'like', "%{$request->search}%")->orWhere('counters.name', 'like', "%{$request->search}%")
            ->orWhere('queue_number', 'like', "%{(int)$request->search}%")->orWhere('is_processed', 'like', "%{$request->search}%")
            ->orWhere('date', 'like', "%{date($request->search)}%")
            ->paginate(10);

            return response()->json([
                'message' => 'Heres ur Queue',
                'data' => $counter
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something Wrong',
                'error' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('queue::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $lastValue = DB::table('user_counters')->where('counter_id', '=', $request->counter_id)->where('date', Date('Y-m-d'))->latest()->first();
            
            $counter = new user_counter;
            $counter->user_id = $request->user_id;
            $counter->counter_id = $request->counter_id;
            
            if(isset($lastValue)){
                $part = explode('-', $lastValue->queue_number);
                
                $counter->queue_number = $part[0]+1;
            }else{
                $counter->queue_number = 1;
            } 

            $counter->is_processed = $request->is_processed;
            $counter->date = $request->date;
            $counter->save();

            $counters = user_counter::join('users', 'user_counters.user_id', '=', 'users.id')->where('user_id', '=', $request->user_id)
            ->join('counters', 'user_counters.counter_id', '=', 'counters.id')->where('counter_id', '=', $request->counter_id)
            ->select('users.name as Name', 'email', 'nik', 'counters.name as Counter Name', 'queue_number', 'is_processed', 'date')
            ->paginate(5);

            return response()->json([
                'message' => 'Successfully Added',
                'data' => $counters
            ],200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something Wrong',
                'error' => $th->getMessage()
            ],400);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('queue::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('queue::edit');
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
            $counter = user_counter::find($id);
            $counter->delete();
            $counter->save();

            return response()->json([
                'message' => 'Successfully deleted',
                'data' => $counter
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
