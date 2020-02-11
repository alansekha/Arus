<?php

namespace Modules\Queue\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Queue\Entities\Counter;

class CounterController extends Controller
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

            $counter = Counter::orderBy($orderBy,  $orderByType)->paginate(5);
            return response()->json([
                'Message' => 'Here u Got',
                'data' => $counter
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => 'Here u Got',
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
            $counter = new Counter;
            $counter->name = $request->counter_name;
            $counter->save();

            return response()->json([
                'Message' => 'Successfully Added Counter',
                'data' => $counter
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => 'Something Wrong',
                'error' => $th->getMessage()
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
        try {
            $counter = Counter::find($id);
            $counter->name = $request->counter_name;
            $counter->save();

            return response()->json([
                'Message' => 'Successfully Edit Counter',
                'data' => $counter
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => 'Something Wrong',
                'error' => $th->getMessage()
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
            $counter = Counter::find($id);
            $counter->delete();
            $counter->save();

            return response()->json([
                'Message' => 'Successfully Delete Counter',
                'data' => $counter
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'Message' => 'Something Wrong',
                'error' => $th->getMessage()
            ], 400);
        }
    }
}
