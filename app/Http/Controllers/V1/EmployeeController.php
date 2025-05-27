<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\traits\ApiResponse;
use Exception;
class EmployeeController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $employee = Employee::get();
            $responseData = $employee->map(function ($employee) {
                return [
                    'employee_id' => $employee->employee_id,
                    'first_name' => $employee->first_name,
                    'last_name' => $employee->last_name,
                    'email' => $employee->email,
                    'phone' => $employee->phone,
                    'gender' => $employee->gender,
                    'dob' => $employee->dob,
                    'photo' => $employee->photo,
                    'role_id' => $employee->role_id,
                    'company_id' => $employee->company_id,
                    'user_id' => $employee->user_id
                ];
            });
            return $this->successResponse($responseData, "Employees Data Fetched");

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Exception Occured");
        }
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
    public function store(EmployeeRequest $request)
    {
        try {
            $validate = $request->validated();

            // Merge remaining non-validated fields if needed
            $other = $request->except(array_keys($validate));
            $other['password'] = bcrypt($other['password']);
            $data = array_merge($validate, $other);

            $uploadPath = 'Documents/Profile/';

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                $imageFile = $request->file('photo');
                $uniqueImageName = time() . '_img_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path($uploadPath), $uniqueImageName);
                $data['photo'] = $uploadPath . $uniqueImageName;
            }

            $employee = Employee::create($data);
            $responseData = [
                'employee_id' => $employee->employee_id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'gender' => $employee->gender,
                'dob' => $employee->dob,
                'photo' => $employee->photo,
                'role_id' => $employee->role_id,
                'company_id' => $employee->company_id,
                'user_id' => $employee->user_id
            ];

            return $this->successResponse($responseData, "Employee Created Successfully");

        } catch (QueryException $qe) {

            return $this->errorResponse($qe->getMessage(), 'Database Error');

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 'Exception Occurred');
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $employee_id)
    {
        try {
            $employee = Employee::find($employee_id);
            if ($employee) {
                $responseData = [
                    'employee_id' => $employee->employee_id,
                    'first_name' => $employee->first_name,
                    'last_name' => $employee->last_name,
                    'email' => $employee->email,
                    'phone' => $employee->phone,
                    'gender' => $employee->gender,
                    'dob' => $employee->dob,
                    'photo' => $employee->photo,
                    'role_id' => $employee->role_id,
                    'company_id' => $employee->company_id,
                    'user_id' => $employee->user_id
                ];

                return $this->successResponse($responseData, "Employee Data Fetched");
            } else {
                return $this->errorResponse("Employee Not Found", "No Employee Found With ID $employee_id");
            }


        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Exception Occured");
        }
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
    public function update(EmployeeRequest $request, $employee_id)
    {
        try {
            $employee = Employee::find($employee_id);

            if (!$employee) {
                return $this->errorResponse("Employee not found", "Not Found", 404);
            }

            $validate = $request->validated();

            // Merge remaining non-validated fields if needed
            $other = $request->except(array_keys($validate));
            $data = array_merge($validate, $other);

            $uploadPath = 'Documents/Profile/';

            if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
                // Optional: Delete old photo if needed
                if ($employee->photo && file_exists(public_path($employee->photo))) {
                    unlink(public_path($employee->photo));
                }

                $imageFile = $request->file('photo');
                $uniqueImageName = time() . '_img_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path($uploadPath), $uniqueImageName);
                $data['photo'] = $uploadPath . $uniqueImageName;
            }

            $employee->update($data);
            $responseData = [
                'employee_id' => $employee->employee_id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'gender' => $employee->gender,
                'dob' => $employee->dob,
                'photo' => $employee->photo,
                'role_id' => $employee->role_id,
                'company_id' => $employee->company_id,
                'user_id' => $employee->user_id
            ];

            return $this->successResponse($responseData, "Employee updated successfully");

        } catch (QueryException $qe) {
            return $this->errorResponse($qe->getMessage(), 'Database Error');

        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 'Exception Occurred');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $employee = Employee::find($id);

            if ($employee) {
                $employee->status = 0;
                $employee->save();
                $responseData = [
                    'employee_id' => $employee->employee_id,
                    'first_name' => $employee->first_name,
                    'last_name' => $employee->last_name,
                    'email' => $employee->email,
                    'phone' => $employee->phone,
                    'gender' => $employee->gender,
                    'dob' => $employee->dob,
                    'photo' => $employee->photo,
                    'role_id' => $employee->role_id,
                    'company_id' => $employee->company_id,
                    'user_id' => $employee->user_id
                ];

                return $this->successResponse($responseData, "Employee Deactivated Successfully");
            } else {
                return $this->errorResponse("Records not found", "Employee Not Found");
            }
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Error Occured");
        }
    }
}
