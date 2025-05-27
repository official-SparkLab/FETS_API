<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
class employee extends Model
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
        'role_id',
        'password',
        'company_id',
        'user_id',
        
    ];
}
