<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeOther extends Model
{
    protected $table = "employee_other";
    protected $primaryKey="id";
   protected $fillable = [
    'education',
    'experience',
    'bank_account_number',
    'ifsc',
    'aadhar_no',
    'emp_id',
];

}
