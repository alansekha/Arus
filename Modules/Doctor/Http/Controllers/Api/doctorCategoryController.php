<?php

namespace Modules\Doctor\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Doctor\Entities\doctor_category;
use Illuminate\Support\Facades\Validator;

class doctorCategoryController extends Controller
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

            $category = doctor_category::where('name', 'like', "%{$request->search}%")
            ->orderBy($orderBy, $orderByType)->paginate(5);
            return response()->json([
                "message" => "Here you got",
                "data" => $category
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Something Wrong",
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
        // 
    }
    
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $messages = [
                'speciality_name.required' => 'You must input data',
                'speciality_name.max' => 'name must be less than 255 caracter',
                'speciality_name.alpha_num' => 'you cant add special caracter'
            ];

            $validator = Validator::make($request->all(), [
                'speciality_name' => 'required|alpha_num|max:255',
            ],$messages);

            if ($validator->fails()) {
                $this->data['message'] = 'error';
                $this->data['error'] = $validator->errors();
                return $this->data;
            }

            $category = new doctor_category;
            $category->name = $request->get('speciality_name');
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
            
            $messages = [
                'speciality_name.required' => 'You must input data',
                'speciality_name.max' => 'name must be less than 255 caracter',
                'speciality_name.alpha_num' => 'you cant add special caracter'
            ];

            $validator = Validator::make($request->all(), [
                'speciality_name' => 'required|alpha_num|max:255',
            ],$messages);

            if ($validator->fails()) {
                $this->data['message'] = 'error';
                $this->data['error'] = $validator->errors();
                return $this->data;
            }
            
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
