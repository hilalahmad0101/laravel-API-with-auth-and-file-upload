<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        $product=new Product();

        $rules=[
            "product_title"=>"required",
            "product_desc"=>"required",
            "product_image"=>"required",
        ];
        $validation=Validator::make($request->all(),$rules);
        if($validation->fails()){
            return response()->json($validation->errors());
        }else{
            $file=$request->file("product_image");
            $new_file=rand().".".$file->extension();
            $file->move(public_path("upload/images"),$new_file);

            $product->product_title=$request->product_title;
            $product->product_desc=$request->product_desc;
            $product->product_image=$new_file;
            $result=$product->save();
            if($result){
                return response()->json(["message"=>"Product Add Successfully"]);
            }else{
                return response()->json(["message"=>"Product Not Add Successfully"]);
            }
        }
    }
    public function getProduct()
    {
        $product=Product::all();
        return response()->json($product);
    }

    public function editProduct($id){
        $product=Product::find($id);
        return response()->json($product);
    }
    public function updateProduct(Request $request,$id)
    {
        $product=Product::find($id);

        // if($request->hasFile("product_image")){
            $destinaiton=public_path("upload\\images\\".$product->product_image);
            if(File::exists($destinaiton)){
                unlink($destinaiton);
            }
                $file=$request->file("edit_product_image");
                $new_file=rand().".".$file->extension();
                $file->move(public_path("upload/images"),$new_file);
               
        // }
        $product->product_title=$request->product_title;
        $product->product_desc=$request->product_desc;
        $product->product_image=$new_file;
        $result=$product->save();
        if($result){
            return response()->json(["message"=>"Product update Successfully"]);
        }else{
            return response()->json(["message"=>"Product Not update Successfully"]);
        }
    }

    public function deleteProduct($id)
    {
        $product=Product::find($id);
        $destinaiton=public_path("upload\\images\\".$product->product_image);

        if(File::exists($destinaiton)){
            unlink($destinaiton);
        }
        $result=$product->delete();
        if($result){
            return response()->json(["message"=>"Product Delete Successfully"]);
        }else{
            return response()->json(["message"=>"Product Not Delete Successfully"]);
        }
    }
}
