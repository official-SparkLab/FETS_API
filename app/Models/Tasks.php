<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = "tasks";
    protected$primaryKey="id";
    protected $fillable = [
    'title',
    'description',
    'priority',
    'task_date',
    'due_date',
    'attachment',
    'recuring',
   
    'assign_to',
    'department',
    'company_id',
    'created_by',
    ];
}
