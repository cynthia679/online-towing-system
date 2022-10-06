<?php

namespace App\Http\Controllers;

use App\Conf\Config;
use App\Helpers\GeneralFunctions;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller

{
    private $functions;

    function __construct()
    {
        $this->functions = new GeneralFunctions();
    }

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
            $userId = $request->userId;
              $customerRequestId = $request->customerRequestId;
            $clientId = $request->clientId;
               $fromAddress = $request->fromAddress;
                $toAddress = $request->toAddress;
                 $charge = $request->charge;
                  $distance = $request->distance;
                   $status = $request->Config::ACTIVE;
                    $dateModified = $request->dateModified;
                     $dateCreated = $request->$this->functions->curlDate();
            $orders =Order::create([
                "userId"=>$userId,
                "customerRequestId"=>$customerRequestId,
                "clientId"=>$clientId,
                "fromAddress"=>$fromAddress,
                "toAddress"=>$toAddress,
                "charge"=>$charge,
                "distance"=>$distance,
                "status"=>Config::ACTIVE,
                "dateModified"=>$dateModified,
                "dateCreated"=>$this->functions->curlDate(),
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
            $id=$request->id;
            $userId = $request->userId;
            $customerRequestId = $request->customerRequestId;
            $clientId = $request->clientId;
            $fromAddress = $request->fromAddress;
            $toAddress = $request->toAddress;
            $charge = $request->charge;
            $distance = $request->distance;
            $status = $request->Config::ACTIVE;
            $dateModified = $request->dateModified;
            $dateCreated = $request->$this->functions->curlDate();
            $recordsUpdated =Order::where(['id'=>$id])
                ->update([
                    "userId"=>$userId,
                    "customerRequestId"=>$customerRequestId,
                    "clientId"=>$clientId,
                    "fromAddress"=>$fromAddress,
                    "toAddress"=>$toAddress,
                    "charge"=>$charge,
                    "distance"=>$distance,
                    "status"=>Config::ACTIVE,
                    "dateModified"=>$dateModified,
                    "dateCreated"=>$this->functions->curlDate(),
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

