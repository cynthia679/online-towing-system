<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $product = Product::all();
            if(count($product) > 0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"ProductsFetched Successfully",
                    "DATA"=>$product
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Records Found",
                    "DATA"=>$product
                );
            }
        }catch (\Exception $e)
        {
            $response = array(
                "STATUS"=>Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" =>Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA"=>[]
            );
        }
        return json_encode($response);
    }
    public function create(Request $request)
    {
        try {
            $name = $request->name;
            $product =Product::create([
                "name"=>$name
            ]);
            if(isset($product->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Product Created Successfully",
                    "DATA"=>$product
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"Error occurred in creating Product",
                    "DATA"=>$product
                );
            }
        }catch (\Exception $e)
        {
            $response = array(
                "STATUS"=>Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" =>Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA"=>[]
            );
        }
        return json_encode($response);
    }
    public function update(Request $request)
    {
        try {
            $name = $request->name;
            $id = $request->id;
            $recordsUpdated =Product::where(['id'=>$id])
                ->update([
                    "name"=>$name
                ]);
            if($recordsUpdated >0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Product Updated Successfully",
                    "DATA"=>[]
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"Error occurred in updating",
                    "DATA"=>[]
                );
            }
        }catch (\Exception $e)
        {
            $response = array(
                "STATUS"=>Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" => Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA"=>[]
            );
        }
        return json_encode($response);
    }

    public function findById(Request $request)
    {
        try {
            $orders = Category::where(['id'=>$request->id])->first();
            if(isset($product->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Product Fetched Successfully",
                    "DATA"=>$product
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Product Found",
                    "DATA"=>[]
                );
            }
        }catch (\Exception $e)
        {
            $response = array(
                "STATUS"=>Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" => Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA"=>[]
            );
        }
        return json_encode($response);
    }
    public function deleteById(Request $request)
    {
        try {
            $records = Product::where(['id'=>$request->id])->delete();
            if(isset($records)>0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Product deleted Successfully",
                    "DATA"=>[]
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Product Found",
                    "DATA"=>[]
                );
            }
        }catch (\Exception $e)
        {
            $response = array(
                "STATUS"=>Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" => Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA"=>[]
            );
        }
        return json_encode($response);

}


}
