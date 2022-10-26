<?php

namespace App\Http\Controllers;

use App\Conf\Config;
use App\Helpers\GeneralFunctions;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $functions;

    function __construct()
    {
        $this->functions = new GeneralFunctions();
    }

    public function index()
    {
        try {
            $users = User::all();
            if(count($users) > 0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"UserFetched Successfully",
                    "DATA"=>$users
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No users Found",
                    "DATA"=>$users
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
            $status = Config::ACTIVE;
            $activationCode = $request->activationCode;
            $email = $request->email;
            $password= $request->password;
            $users =User::create([
                "name" => $name,
                "status" => Config::ACTIVE,
                "activationCode" => $activationCode,
                "activatedAt" => $this->functions->curlDate(),
                "email" => $email,
                "password" => $password,
            ]);
            if(isset($users->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"User Created Successfully",
                    "DATA"=>$users
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"Error occurred in creating Users",
                    "DATA"=>$users
                );
            }
        }catch (\Exception $e)
        {
            $response = array(
                "STATUS"=>Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" =>Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA"=>[]
            );
            dd($e->getMessage());
        }
        return json_encode($response);
    }
    public function update(Request $request)
    {
        try {
            $name = $request->name;
            $status = Config::ACTIVE;
            $activationCode = $request->activationCode;
            $email = $request->email;
            $password= $request->password;
            $recordsUpdated =User::where(['id' => $request->id])
                ->update([
                    "name"=>$name,
                    "status"=>Config::ACTIVE,
                    "activationCode"=>$activationCode,
                    "activatedAt"=>$this->functions->curlDate(),
                    "email"=>$email,
                    "password"=>$password,

                ]);

            if($recordsUpdated >0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"User Updated Successfully",
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
            dd($e->getMessage());

        }
        return json_encode($response);
    }

    public function findById(Request $request)
    {
        try {
            $users = User::where(['id'=>$request->id])->first();
            if(isset($users->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"User Fetched Successfully",
                    "DATA"=>$users
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No User Found",
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
            $records = User::where(['id'=>$request->id])->delete();
            if(isset($records)>0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"User deleted Successfully",
                    "DATA"=>[]
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No User Found",
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

