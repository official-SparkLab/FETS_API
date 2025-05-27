<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
class Login extends Controller
{
    public function userLogin(Request $request)
    {

        $employee = Employee::where('email', $request->login)
            ->orWhere('phone', $request->login)
            ->first();

        if (!$employee || !Hash::check($request->password, $employee->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        } else {

            // Delete all previous tokens
            $employee->tokens()->delete();

            // 🔐 Create new token
            $token = $employee->createToken('employee-token')->plainTextToken;
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
            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'token' => $token,
                'data' => $responseData
            ]);

        }
    }
}
