<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        try {
            $transaction= Transaction::all();
            if(count($transaction) > 0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"transactionFetched Successfully",
                    "DATA"=>$transaction
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Records Found",
                    "DATA"=>$transaction
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
            $orders =Transaction::create([
                "name"=>$name
            ]);
            if(isset($transaction->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Transaction Created Successfully",
                    "DATA"=>$transaction
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"Error occurred in creating Transaction",
                    "DATA"=>$transaction
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
            $recordsUpdated =Transaction::where(['id'=>$id])
                ->update([
                    "name"=>$name
                ]);
            if($recordsUpdated >0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Transaction Updated Successfully",
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
            $orders =Transaction::where(['id'=>$request->id])->first();
            if(isset($transaction->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Transaction Fetched Successfully",
                    "DATA"=>$transaction
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Transaction Found",
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
            $records = Transaction::where(['id'=>$request->id])->delete();
            if(isset($records)>0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Transaction deleted Successfully",
                    "DATA"=>[]
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Transaction Found",
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

