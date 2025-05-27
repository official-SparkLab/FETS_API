<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class EmployeeAddress extends Model
{
    
    use HasApiTokens;

    protected $table="employee_addresses";
    protected $primaryKey="id";

    protected $fillable=[
        'address',
        'city',
        'state',
        'pin_code',
        'emp_id',
    ];
}
