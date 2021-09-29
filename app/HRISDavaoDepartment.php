<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HRISDavaoDepartment extends Model
{
    protected $connection = "sqlsrv_dvo_hris";
    protected $table = 'hrdepartment';
}
