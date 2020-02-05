<?php

namespace Modules\Doctor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Doctor\Entities\doctor_category;

class doctorCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {
            $category = doctor_category::paginate(5);
            return response()->json([
                "message" => "Here you got",
                "data" => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something Wrong",
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
        // 
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $category = new doctor_category;
            $category->name = $request->speciality_name;
            $category->save();
            return response()->json([
                "message" => "Category Successfully add",
                "data" => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something Wrong",
                "data" => Null
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
            $category = doctor_category::find($id);
            $category->name = $request->speciality_name;
            $category->save();
            return response()->json([
                "message" => "Category Successfully updated",
                "data" => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something Wrong",
                "data" => Null
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
            $category = doctor_category::find($id);
            $category->delete();
            $category->save();
            return response()->json([
                "message" => "Category Successfully deleted",
                "data" => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something Wrong",
                "data" => Null
            ], 400);
        }
    }
}
