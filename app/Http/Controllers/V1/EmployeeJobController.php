<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Models\EmployeeJob;
use App\traits\ApiResponse;
use App\Http\Requests\EmployeeJobRequest;
class EmployeeJobController extends Controller
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
   public function store(EmployeeJobRequest $request)
{
    try {
        $validate = $request->validated();

        // Merge remaining non-validated fields if needed
        $other = $request->except(array_keys($validate));
        $data = array_merge($validate, $other);

        $employeeJob = EmployeeJob::create($data);

        $responseData = [
            'employee_job_id' => $employeeJob->id,
            'designation'     => $employeeJob->designation,
            'department'      => $employeeJob->department,
            'emp_type'        => $employeeJob->emp_type,
            'joining_date'    => $employeeJob->joining_date,
            'work_location'   => $employeeJob->work_location,
            'emp_id'          => $employeeJob->emp_id
        ];

        return $this->successResponse($responseData, "Employee Job Details Created Successfully");

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
   public function update(EmployeeJobRequest $request, string $id)
{
    try {
        $validation = $request->validated();

        
        $other = $request->except(array_keys($validation));
        $data = array_merge($validation, $other);

        
        $employeeJob = EmployeeJob::where("emp_id", $id)->firstOrFail();

        
        $employeeJob->update($data);

        return $this->successResponse($employeeJob, "Employee Job Details Updated");

    } catch (Exception $ex) {
        return $this->errorResponse($ex->getMessage(), "Error Occurred");
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
