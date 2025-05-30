<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = "clients";
    protected $primaryKey = "id";

    protected $fillable = [
        'client_name',
        'email_address',
        'contact_number',
        'business_name',
        'address',
        'city',
        'state',
        'pin_code',
        'gst_no',
        'client_type',
      
        'company_id',
        'created_by'
    ];
}
