<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller

{
    public function index()
    {
        try {
            $orders = Order::all();
            if(count($orders) > 0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"OrdersFetched Successfully",
                    "DATA"=>$orders
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Records Found",
                    "DATA"=>$orders
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
            $orders =Order::create([
                "name"=>$name
            ]);
            if(isset($orders->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Orders Created Successfully",
                    "DATA"=>$orders
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"Error occurred in creating Orders",
                    "DATA"=>$orders
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
            $recordsUpdated =Order::where(['id'=>$id])
                ->update([
                    "name"=>$name
                ]);
            if($recordsUpdated >0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Order Updated Successfully",
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
            if(isset($orders->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"orders Fetched Successfully",
                    "DATA"=>$orders
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Orders Found",
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
            $records = Order::where(['id'=>$request->id])->delete();
            if(isset($records)>0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Order deleted Successfully",
                    "DATA"=>[]
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Order Found",
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

