<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeJob extends Model
{
    protected $table = "employee_job";
    protected$primaryKey="id";
    protected $fillable = [
           "designation",
            "department",
            "emp_type",
            "joining_date",
            "work_location",
            "emp_id",
    ] ;
}
