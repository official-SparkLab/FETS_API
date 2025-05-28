<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Company;
use App\traits\ApiResponse;
use App\Http\Requests\CompanyRequest;

class CompanyController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $company = Company::get();
            $responseData = $company->map(function ($company) {
                $responseData = [
                    'company_id' => $company->id,
                    'company_name' => $company->company_name,
                    'contact_no' => $company->contact_no,
                    'email' => $company->email,
                    'address' => $company->address,
                    'city' => $company->city,
                    'state' => $company->state,
                    'pin_code' => $company->pin_code,
                    'reg_number' => $company->reg_number,
                    'gst_no' => $company->gst_no,
                    'logo' => $company->logo,
                    'status' => $company->status,
                    'user_id' => $company->user_id,
                    'created_at' => $company->created_at,
                    'updated_at' => $company->updated_at,
                ];
            });
            return $this->successResponse($company, 'Company Created Successfully');

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), "Exception Occured");
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
    public function store(CompanyRequest $request)
    {
        try {
            $validate = $request->validated();
            $other = $request->except(array_keys($validate));
            $data = array_merge($validate, $other);

            $uploadPath = 'Documents/Logo/';

            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $imageFile = $request->file('logo');
                $uniqueImageName = time() . '_img_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path($uploadPath), $uniqueImageName);
                $data['logo'] = $uploadPath . $uniqueImageName;
            }

            $company = Company::create($data);

            $responseData = [
                'company_id' => $company->id,
                'company_name' => $company->company_name,
                'contact_no' => $company->contact_no,
                'email' => $company->email,
                'address' => $company->address,
                'city' => $company->city,
                'state' => $company->state,
                'pin_code' => $company->pin_code,
                'reg_number' => $company->reg_number,
                'gst_no' => $company->gst_no,
                'logo' => $company->logo,
                'status' => $company->status,
                'user_id' => $company->user_id,
                'created_at' => $company->created_at,
                'updated_at' => $company->updated_at,
            ];
            return $this->successResponse($company, 'Company Created Successfully');
        } catch (QueryException $qe) {

            return $this->errorResponse($qe->getMessage(), 'Database Error');

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), "Exception Occured");
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $company = Company::find($id);
            if ($company) {
                $responseData = [
                    'company_id' => $company->id,
                    'company_name' => $company->company_name,
                    'contact_no' => $company->contact_no,
                    'email' => $company->email,
                    'address' => $company->address,
                    'city' => $company->city,
                    'state' => $company->state,
                    'pin_code' => $company->pin_code,
                    'reg_number' => $company->reg_number,
                    'gst_no' => $company->gst_no,
                    'logo' => $company->logo,
                    'status' => $company->status,
                    'user_id' => $company->user_id,
                    'created_at' => $company->created_at,
                    'updated_at' => $company->updated_at,
                ];

                return $this->successResponse($company, 'Company Fetched Successfully');
            } else {
                return $this->errorResponse('Company not found', 'Company not found');
            }

        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), "Exception Occured");
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
    public function update(CompanyRequest $request, $id)
    {
        try {
            $company = Company::findOrFail($id);

            $validate = $request->validated();
            $other = $request->except(array_keys($validate));
            $data = array_merge($validate, $other);

            $uploadPath = 'Documents/Logo/';

            // Handle logo upload if a new file is sent
            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                $imageFile = $request->file('logo');
                $uniqueImageName = time() . '_img_' . uniqid() . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path($uploadPath), $uniqueImageName);
                $data['logo'] = $uploadPath . $uniqueImageName;

                // Optionally delete old logo file
                if ($company->logo && file_exists(public_path($company->logo))) {
                    unlink(public_path($company->logo));
                }
            }

            $company->update($data);

            $responseData = [
                'company_id' => $company->id,
                'company_name' => $company->company_name,
                'contact_no' => $company->contact_no,
                'email' => $company->email,
                'address' => $company->address,
                'city' => $company->city,
                'state' => $company->state,
                'pin_code' => $company->pin_code,
                'reg_number' => $company->reg_number,
                'gst_no' => $company->gst_no,
                'logo' => $company->logo,
                'status' => $company->status,
                'user_id' => $company->user_id,

            ];

            return $this->successResponse($responseData, 'Company Updated Successfully');

        } catch (QueryException $qe) {
            return $this->errorResponse($qe->getMessage(), 'Database Error');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Exception Occurred');
        }
    }
    protected function failedValidation(Validator $validator)
{
    throw new HttpResponseException(response()->json([
        'success' => false,
        'message' => 'Validation Error',
        'errors'  => $validator->errors()
    ], 422));
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        try {
            $company = Company::find($id);

            if ($company) {
                $company->status = 0;
                $company->save();

                $responseData = [
                    'company_id' => $company->id,
                    'company_name' => $company->company_name,
                    'contact_no' => $company->contact_no,
                    'email' => $company->email,
                    'address' => $company->address,
                    'city' => $company->city,
                    'state' => $company->state,
                    'pin_code' => $company->pin_code,
                    'reg_number' => $company->reg_number,
                    'gst_no' => $company->gst_no,
                    'logo' => $company->logo,
                    'status' => $company->status,
                    'user_id' => $company->user_id,

                ];

                return $this->successResponse($responseData, "Company Deactivated Successfully");
            } else {
                return $this->errorResponse("Records not found", "Company Not Found");
            }
        } catch (Exception $ex) {
            return $this->errorResponse($ex->getMessage(), "Error Occurred");
        }
    }

}
