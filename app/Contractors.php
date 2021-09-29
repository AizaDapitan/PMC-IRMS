<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contractors extends Model
{
    protected $connection = "sqlsrv_contractors";
    protected $table = 'contractors';
}

