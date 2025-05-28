<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "company";
    protected $primaryKey = "id";

     protected $fillable = [
        'company_name',
        'contact_no',
        'email',
        'address',
        'city',
        'state',
        'pin_code',
        'reg_number',
        'gst_no',
        'logo',
        'status',
        'user_id',
    ];
}
