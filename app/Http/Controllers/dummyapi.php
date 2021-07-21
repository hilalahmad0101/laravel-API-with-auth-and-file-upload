<?php

namespace App\Http\Controllers;

use App\Models\category;
use Validator;
use Illuminate\Http\Request;

class dummyapi extends Controller
{
    public function index(Request $request)
    {

        $category = category::all();
        return $category;
    }

    public function add(Request $request)
    {
        $rules = [
            "cat_name" => "required",
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return $validation->errors();
        } else {
            $category = new category;
            $is_category = category::where("cat_name", $request->cat_name)->first();
            if ($is_category) {
                return response()->json("this category name already exist");
            } else {
                $category->cat_name = $request->cat_name;
                $result = $category->save();
                if ($result) {
                    return response()->json("Data insert successfully");
                } else {
                    return response()->json("something woring");
                }
            }
        }
    }

    public function edit($id)
    {
        $category = category::find($id);
        return $category;
    }

    public function update(Request $request, $id)
    {
        $category = category::find($id);
        $is_category = category::where("cat_name", $request->cat_name)->first();
        if ($is_category) {
            return response()->json("this category name already exsit");
        } else {
            $category->cat_name = $request->cat_name;
            $result = $category->save();
            if ($result) {
                return response()->json("Data update succcessfully");
            } else {
                return response()->json("Something woring");
            }
        }
    }

    public function delete($id)
    {
        $category = category::find($id);
        $result = $category->delete();
        if ($result) {
            return response()->json("data delete successfully");
        } else {
            return response()->json("something woring");
        }
    }
    public function search($name)
    {
        $search = '%' . $name . '%';
        $category = category::where("cat_name", "like", $search)->get();
        if ($category) {
            return $category;
        } else {
            return response()->json("Record not found");
        }
    }
}