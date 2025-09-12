<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerRequest;
use Illuminate\Support\Facades\Validator;

class CustomerRequestController extends Controller
{
    // ===============================
    // Create a new customer request
    // ===============================
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|integer|exists:users,id',
            'productId' => 'required|integer|exists:products,id',
            'fromAddress' => 'required|string|max:255',
            'fromLongitude' => 'nullable|numeric',
            'fromLatitude' => 'nullable|numeric',
            'toAddress' => 'required|string|max:255',
            'toLongitude' => 'nullable|numeric',
            'toLatitude' => 'nullable|numeric',
            'distance' => 'nullable|numeric',
            'charge' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "STATUS" => "VALIDATION_ERROR",
                "MESSAGE" => $validator->errors()->first(),
                "DATA" => []
            ], 422);
        }

        try {
            $data = $request->all();
            $data['status'] = $data['status'] ?? 'pending';
            $data['dateCreated'] = now();
            $data['dateModified'] = now();

            $customerRequest = CustomerRequest::create($data);

            return response()->json([
                "STATUS" => "SUCCESS",
                "MESSAGE" => "Customer Request Created Successfully",
                "DATA" => $customerRequest
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                "STATUS" => "ERROR",
                "MESSAGE" => "Failed to create customer request",
                "DATA" => []
            ], 500);
        }
    }

    // ===============================
    // Update an existing customer request
    // ===============================
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:customer_requests,id',
            'fromAddress' => 'sometimes|string|max:255',
            'fromLongitude' => 'nullable|numeric',
            'fromLatitude' => 'nullable|numeric',
            'toAddress' => 'sometimes|string|max:255',
            'toLongitude' => 'nullable|numeric',
            'toLatitude' => 'nullable|numeric',
            'distance' => 'nullable|numeric',
            'charge' => 'nullable|numeric',
            'status' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "STATUS" => "VALIDATION_ERROR",
                "MESSAGE" => $validator->errors()->first(),
                "DATA" => []
            ], 422);
        }

        try {
            $customerRequest = CustomerRequest::findOrFail($request->id);
            $data = $request->except('id');
            $data['dateModified'] = now();

            $customerRequest->update($data);

            return response()->json([
                "STATUS" => "SUCCESS",
                "MESSAGE" => "Customer Request Updated Successfully",
                "DATA" => $customerRequest
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "STATUS" => "ERROR",
                "MESSAGE" => "Failed to update customer request",
                "DATA" => []
            ], 500);
        }
    }

    // ===============================
    // Delete a customer request by ID
    // ===============================
    public function deleteById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:customer_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "STATUS" => "VALIDATION_ERROR",
                "MESSAGE" => $validator->errors()->first(),
                "DATA" => []
            ], 422);
        }

        try {
            $deleted = CustomerRequest::where('id', $request->id)->delete();

            if ($deleted) {
                return response()->json([
                    "STATUS" => "SUCCESS",
                    "MESSAGE" => "Customer Request Deleted Successfully",
                    "DATA" => []
                ], 200);
            }

            return response()->json([
                "STATUS" => "NOT_FOUND",
                "MESSAGE" => "Customer Request Not Found",
                "DATA" => []
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                "STATUS" => "ERROR",
                "MESSAGE" => "Failed to delete customer request",
                "DATA" => []
            ], 500);
        }
    }

    // ===============================
    // Find a customer request by ID
    // ===============================
    public function findById(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:customer_requests,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "STATUS" => "VALIDATION_ERROR",
                "MESSAGE" => $validator->errors()->first(),
                "DATA" => []
            ], 422);
        }

        try {
            $customerRequest = CustomerRequest::find($request->id);

            if ($customerRequest) {
                return response()->json([
                    "STATUS" => "SUCCESS",
                    "MESSAGE" => "Customer Request Found",
                    "DATA" => $customerRequest
                ], 200);
            }

            return response()->json([
                "STATUS" => "NOT_FOUND",
                "MESSAGE" => "Customer Request Not Found",
                "DATA" => []
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                "STATUS" => "ERROR",
                "MESSAGE" => "Failed to fetch customer request",
                "DATA" => []
            ], 500);
        }
    }

    // ===============================
    // Optional: List all requests (you can add filters later)
    // ===============================
    public function index()
    {
        try {
            $requests = CustomerRequest::all();
            return response()->json([
                "STATUS" => "SUCCESS",
                "MESSAGE" => "Customer Requests Fetched Successfully",
                "DATA" => $requests
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "STATUS" => "ERROR",
                "MESSAGE" => "Failed to fetch customer requests",
                "DATA" => []
            ], 500);
        }
    }
}
