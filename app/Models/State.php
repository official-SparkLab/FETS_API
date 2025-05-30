<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = "state_master";
    protected $primaryKey = "id";

    protected $fillable = [
        'state_name',
        'created_by',
    ] ;
}
