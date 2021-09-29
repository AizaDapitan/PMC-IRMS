<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HRISDavaoPosition extends Model
{
    protected $connection = "sqlsrv_dvo_hris";
    protected $table = 'hrposition';
}
