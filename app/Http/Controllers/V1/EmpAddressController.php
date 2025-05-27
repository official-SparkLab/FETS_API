<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeAddressRequest;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Models\EmployeeAddress;
use Exception;
use App\traits\ApiResponse;
class EmpAddressController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeAddressRequest $request)
    {
        try {
            $validation = $request->validated();
            $other = $request->except(array_keys($validation));
            $data = array_merge($validation, $other);
            $employeeaddress = EmployeeAddress::create($data);
            $responseData = [
                "address" => $employeeaddress->address,
                "city" => $employeeaddress->city,
                "state" => $employeeaddress->state,
                "pin_code" => $employeeaddress->pin_code,
                "emp_id" => $employeeaddress->emp_id

            ];
            return $this->successResponse($responseData, "Employee Address Details Submitted Successfully");

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), "Exception Occured");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeAddressRequest $request, string $id)
    {
        try {
            $validation = $request->validated();
            $other = $request->except(array_keys($validation));
            $data = array_merge($validation, $other);
            $emp_address = EmployeeAddress::where("emp_id",$id)->firstOrFail();
            if (!$emp_address) {
                return $this->errorResponse("Address record not found", "Not Found");

            } else {
                $emp_address->update($data);
                return $this->successResponse($emp_address,"Address Details Updated");

            }
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Error Occured");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
