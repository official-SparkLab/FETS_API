<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeOtherRequest;
use App\Models\EmployeeOther;
use App\traits\ApiResponse;
use Exception;
class EmoloyeeOtherController extends Controller
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
   public function store(EmployeeOtherRequest $request)
{
    try {
        $validated = $request->validated();

        // Merge any additional fields if needed
        $other = $request->except(array_keys($validated));
        $data = array_merge($validated, $other);

        // Create new record
        $employeeOther = EmployeeOther::create($data);

        return $this->successResponse($employeeOther, "Employee Other Details Saved Successfully");

    } catch (QueryException $qe) {
        return $this->errorResponse($qe->getMessage(), 'Database Error');
    } catch (Exception $ex) {
        return $this->errorResponse($ex->getMessage(), 'Exception Occurred');
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
   public function update(EmployeeOtherRequest $request, string $id)
{
    try {
        // Validate incoming data
        $validated = $request->validated();

        // Merge any extra non-validated fields
        $other = $request->except(array_keys($validated));
        $data = array_merge($validated, $other);

        // Find the EmployeeOther record using emp_id (not primary id)
        $employeeOther = EmployeeOther::where('emp_id', $id)->firstOrFail();

        // Update the record
        $employeeOther->update($data);

        return $this->successResponse($employeeOther, "Employee Other Details Updated");

    
    } catch (QueryException $qe) {
        return $this->errorResponse($qe->getMessage(), 'Database Error');
    } catch (Exception $ex) {
        return $this->errorResponse($ex->getMessage(), "Exception Occurred");
    }
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
