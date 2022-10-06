<?php

namespace App\Http\Controllers;

use App\Conf\Config;
use App\Helpers\GeneralFunctions;
use http\Client;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    private $functions;

    function __construct()
    {
        $this->functions = new GeneralFunctions();
    }

    public function index()
    {
        try {
            $client = Client::all();
            if(count($client) > 0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"clientFetched Successfully",
                    "DATA"=>$client
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Records Found",
                    "DATA"=>$client
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
            $MSISDN = $request->MSISDN;
             $name = $request->firstName;
              $name = $request->lastName;
               $email = $request->email;
                $password = $request->password;
                 $status = $request->Config::ACTIVE;
                  $activationCode = $request->activationCode;
                   $loggedIn = $request->loggedIn;
                    $loggedInAt = $request->$this->functions->curlDate();
                      $dateCreated = $request->$this->functions->curlDate();
            $client =Client::create([
                "name"=>$name,
                "email"=>$email,
                "password"=>$password,
                "status"=>Config::ACTIVE,
                "activationCode "=>$activationCode ,
                "loggedIn"=>$loggedIn,
                "loggedInAt"=>$this->functions->curlDate(),
                "dateCreated"=>$this->functions->curlDate(),

            ]);
            if(isset($client->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Orders Created Successfully",
                    "DATA"=>$client
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"Error occurred in creating Client",
                    "DATA"=>$client
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
            $name = $request->firstName;
            $name = $request->lastName;
            $email = $request->email;
            $password = $request->password;
            $status = $request->Config::ACTIVE;
            $activationCode = $request->activationCode;
            $loggedIn = $request->loggedIn;
            $loggedInAt = $request->$this->functions->curlDate();
            $dateModified = $request->dateModified;
            $dateCreated = $request->$this->functions->curlDate();
            $recordsUpdated =Client::where(['id'=>$id])
                ->update([
                    "name"=>$name,
                    "email"=>$email,
                    "password"=>$password,
                    "status"=>Config::ACTIVE,
                    "activationCode "=>$activationCode ,
                    "loggedIn"=>$loggedIn,
                    "loggedInAt"=>$this->functions->curlDate(),
                    "dateModified"=>$dateModified,
                    "dateCreated"=>$this->functions->curlDate(),
                ]);
            if($recordsUpdated >0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Client Updated Successfully",
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
            $client = Client::where(['id'=>$request->id])->first();
            if(isset($client->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Client Fetched Successfully",
                    "DATA"=>$client
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No client Found",
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
            $records = Client::where(['id'=>$request->id])->delete();
            if(isset($records)>0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Client deleted Successfully",
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
