<?php

namespace App\Http\Controllers;

use App\Conf\Config;
use App\Helpers\GeneralFunctions;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $functions;

    function __construct()
    {
        $this->functions = new GeneralFunctions();
    }

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
        try
        {
            $MSISDN = $request->MSISDN;
             $accountNumber = $request->accountNumber;
                  $amount = $request->amount;
                       $mpesaReceiptNumber = $request->mpesaReceiptNumber;
                        $balance = $request->balance;
                             $transactionDate = $request->$this->functions->curlDate();
                                  $namemerchantRequestID = $request->merchantRequestID;
                                       $checkoutRequestID = $request->checkoutRequestID
                                           $resultCode = $request->resultCode;
                                               $resultDesc = $request->resultDesc;
                                               $status = $request->Config::ACTIVE;
                                               $businessShortCode = $request->businessShortCode;
                                               $transactionType= $request->transactionType;
                                                $dateModified= $request->$this->functions->curlDate();
                                                 $dateCreated= $request->$this->functions->curlDate;


            $transaction =Transaction::create([
                "MSISDN"=>$MSISDN,
                "accountNumber"=>$accountNumber,
                "amount"=>$amount,
                "mpesaReceiptNumber"=>$mpesaReceiptNumber,
                "balance"=>$balance,
                "transactionDate"=>$transactionDate,
                "namemerchantRequestID"=>$namemerchantRequestID,
                "checkoutRequestID"=>$checkoutRequestID,
                "resultCode"=>$resultCode,
                "resultDesc"=>$resultDesc,
                "status "=>Config::ACTIVE ,
                "businessShortCode"=>$businessShortCode,
               "transactionType"=>$transactionType,
                "dateModified"=>$this->functions->curlDate(),
                "dateCreated"=>$this->functions->curlDate(),

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
            $id = $request->id;
            $MSISDN = $request->MSISDN;
            $accountNumber = $request->accountNumber;
            $amount = $request->amount;
            $mpesaReceiptNumber = $request->mpesaReceiptNumber;
            $balance = $request->balance;
            $transactionDate = $request->transactionDate;
            $namemerchantRequestID = $request->merchantRequestID;
            $checkoutRequestID = $request->checkoutRequestID;
                                           $resultCode = $request->resultCode;
                                               $resultDesc = $request->resultDesc;
                                               $status = $request->Config::ACTIVE;
                                               $businessShortCode = $request->businessShortCode;
                                               $transactionType= $request->transactionType;
                                                $dateModified= $request->$this->functions->curlDate();
                                                 $dateCreated= $request->$this->functions->curlDate();
            $recordsUpdated =Transaction::where(['id'=>$id])
                ->update([
                "MSISDN"=>$MSISDN,
                "accountNumber"=>$accountNumber,
                "amount"=>$amount,
                "mpesaReceiptNumber"=>$mpesaReceiptNumber,
                "balance"=>$balance,
                "transactionDate"=>$transactionDate,
                "namemerchantRequestID"=>$namemerchantRequestID,
                "checkoutRequestID"=>$checkoutRequestID,
                "resultCode"=>$resultCode,
                "resultDesc"=>$resultDesc,
                "status "=>Config::ACTIVE,
                "businessShortCode"=>$businessShortCode,
               "transactionType"=>$transactionType,
                "dateModified"=>$this->functions->curlDate(),
                "dateCreated"=>$this->functions->curlDate(),
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

