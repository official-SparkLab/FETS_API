<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class Employee extends Model
{

      use HasApiTokens;
    protected $table="employees";
    protected $primaryKey="employee_id";
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'dob',
        'photo',
        'password',
        'role',
        'company_id',
        'user_id',
        
    ];
}
