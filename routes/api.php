<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\EmployeeController;
use App\Http\Controllers\V1\Login;
use App\Http\Controllers\V1\EmpAddressController;
use App\Http\Controllers\V1\EmployeeJobController;
use App\Http\Controllers\V1\EmoloyeeOtherController;
use App\Http\Controllers\V1\CompanyController;
use App\Http\Controllers\V1\StateController;
use App\Http\Controllers\V1\TasksController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');





Route::prefix('v1')->group(function()
{
Route::resource('/super-admin',EmployeeController::class);
Route::POST("/user-login", [Login::class,"userLogin"]);


 Route::middleware('auth:sanctum')->group(function () {
        //Employees APIs
        Route::resource('/employee', EmployeeController::class);
        Route::Resource("/address",EmpAddressController::class);
        Route::Resource("/job",EmployeeJobController::class);
        Route::Resource("/other-details",EmoloyeeOtherController::class);
        Route::resource("/company",CompanyController::class);
        Route::resource("/state", StateController::class);
       Route::resource("/tasks",TasksController::class);
       Route::POST("/get-super-tasks",[TasksController::class,"getTaskToSuperAdmin"]);
       Route::POST("/get-admin-tasks",[TasksController::class,"getTaskToAdmin"]);
    });
}
);

Route::get('/login', function () {
    return response()->json([
        'success' => false,
        'message' => 'User not authenticated'
    ], 401);
})->name('login');