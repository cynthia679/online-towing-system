<?php

namespace App\Http\Controllers;

use App\Conf\Config;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::all();
            if(count($categories) > 0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Categories Fetched Successfully",
                    "DATA"=>$categories
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Records Found",
                    "DATA"=>$categories
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
              $status = $request->status;
              $dateModified = $request->dateModified;
                $dateCreated = $request->dateCreated;

            $category =Category::create([
                "name"=>$name,
                     "status"=>$status,
                     "dateModified"=>$dateModified,
                     "dateCreated"=>$dateCreated,
            ]);
            if(isset($category->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Category Created Successfully",
                    "DATA"=>$category

                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"Error occurred in creating Category",
                    "DATA"=>$category
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
            $status = $request->status;
            $dateModified = $request->dateModified;
            $dateCreated = $request->dateCreated;
            $recordsUpdated =Category::where(['id'=>$id])
                ->update([
                    "name"=>$name,
                     "status"=>$status,
                     "dateModified"=>$dateModified,
                     "dateCreated"=>$dateCreated,
                ]);
            if($recordsUpdated >0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Category Updated Successfully",
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
            $category = Category::where(['id'=>$request->id])->first();
            if(isset($category->id))
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Category Fetched Successfully",
                    "DATA"=>$category
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Category Found",
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
            $records = Category::where(['id'=>$request->id])->delete();
            if(isset($records)>0)
            {
                $response = array(
                    "STATUS"=>Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" =>"Category deleted Successfully",
                    "DATA"=>[]
                );
            }else
            {
                $response = array(
                    "STATUS"=>Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" =>"No Category Found",
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
