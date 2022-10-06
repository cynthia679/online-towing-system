<?php

namespace App\Http\Controllers;

use App\Conf\Config;
use App\Helpers\GeneralFunctions;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $functions;

    function __construct()
    {
        $this->functions = new GeneralFunctions();
    }

    public function index()
    {
        try {
            $product = Product::all();
            if (count($product) > 0) {
                $response = array(
                    "STATUS" => Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" => "ProductsFetched Successfully",
                    "DATA" => $product
                );
            } else {
                $response = array(
                    "STATUS" => Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" => "No Records Found",
                    "DATA" => $product
                );
            }
        } catch (\Exception $e) {
            $response = array(
                "STATUS" => Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" => Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA" => []
            );
        }
        return json_encode($response);
    }

    public function create(Request $request)
    {
        try {

            $name = $request->name;
            $make = $request->make;
            $yom = $request->yom;
            $registrationNumber = $request->registrationNumber;
            $color = $request->color;
            $description = $request->description;
            $product = Product::create([
                "name" => $name,
                "make" => $make,
                "yom" => $yom,
                "registrationNumber" => $registrationNumber,
                "color" => $color,
                "description" => $description,
                "status" => Config::ACTIVE,
                "dateCreated" => $this->functions->curlDate(),
            ]);
            if (isset($product->id)) {
                $response = array(
                    "STATUS" => Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" => "Product Created Successfully",
                    "DATA" => $product
                );
            } else {
                $response = array(
                    "STATUS" => Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" => "Error occurred in creating Product",
                    "DATA" => $product
                );
            }
        } catch (\Exception $e) {
            $response = array(
                "STATUS" => Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" => Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA" => []
            );
        }
        return json_encode($response);
    }

    public function update(Request $request)
    {
        try {
            $name = $request->name;
            $id = $request->id;
            $make = $request->make;
            $yom = $request->yom;
            $registrationNumber = $request->registrationNumber;
            $color = $request->color;
            $description = $request->description;
            $recordsUpdated = Product::where(['id' => $id])
                ->update([
                    "name" => $name,
                    "make" => $make,
                    "yom" => $yom,
                    "registrationNumber" => $registrationNumber,
                    "color" => $color,
                    "description" => $description,
                    "status" => Config::ACTIVE,
                    "dateModified" => $this->functions->curlDate()
                ]);
            if ($recordsUpdated > 0) {
                $response = array(
                    "STATUS" => Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" => "Product Updated Successfully",
                    "DATA" => []
                );
            } else {
                $response = array(
                    "STATUS" => Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" => "Error occurred in updating",
                    "DATA" => []
                );
            }
        } catch (\Exception $e) {
            $response = array(
                "STATUS" => Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" => Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA" => []
            );
        }
        return json_encode($response);
    }

    public function findById(Request $request)
    {
        try {
            $product = Product::where(['id' => $request->id])->first();
            if (isset($product->id)) {
                $response = array(
                    "STATUS" => Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" => "Product Fetched Successfully",
                    "DATA" => $product
                );
            } else {
                $response = array(
                    "STATUS" => Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" => "No Product Found",
                    "DATA" => []
                );
            }
        } catch (\Exception $e) {
            $response = array(
                "STATUS" => Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" => Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA" => []
            );
        }
        return json_encode($response);
    }

    public function deleteById(Request $request)
    {
        try {
            $records = Product::where(['id' => $request->id])->delete();
            if (isset($records) > 0) {
                $response = array(
                    "STATUS" => Config::SUCCESSFULLY_PROCESSED_REQUEST,
                    "MESSAGE" => "Product deleted Successfully",
                    "DATA" => []
                );
            } else {
                $response = array(
                    "STATUS" => Config::RECORD_NOT_FOUND_CODE,
                    "MESSAGE" => "No Product Found",
                    "DATA" => []
                );
            }
        } catch (\Exception $e) {
            $response = array(
                "STATUS" => Config::GENERIC_EXCEPTION_CODE,
                "MESSAGE" => Config::GENERIC_EXCEPTION_MESSAGE,
                "DATA" => []
            );
        }
        return json_encode($response);

    }


}
