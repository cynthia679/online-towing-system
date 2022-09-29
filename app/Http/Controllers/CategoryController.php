<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $response = array(
            "STATUS"=>200,
            "MESSAGE" =>"Categories Fetched Successfully",
            "DATA"=>$categories
        );
        return json_encode($response);
    }
    public function create(Request $request)
    {
        $name = $request->name;
        $category =Category::create([
            "name"=>$name
        ]);
        $response = array(
            "STATUS"=>200,
            "MESSAGE" =>"Category Created Successfully",
            "DATA"=>$category
        );
        return json_encode($response);
    }
}
