<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HRISAgusanDepartment extends Model
{
    protected $connection = "sqlsrv_agn_hris";
    protected $table = 'hrdepartment';
}
