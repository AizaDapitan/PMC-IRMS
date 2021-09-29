<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HRISAgusanPosition extends Model
{
    protected $connection = "sqlsrv_agn_hris";
    protected $table = 'hrposition';
}
