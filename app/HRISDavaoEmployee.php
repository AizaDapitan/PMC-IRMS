<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HRISDavaoEmployee extends Model
{
    protected $connection = "sqlsrv_dvo_hris";
    protected $table = 'viewhrempmaster';

    public function deptDetails()
    {
    	return $this->belongsTo('\App\HRISDavaoDepartment','DeptID','DeptID');
    }

    public function positionDetails()
    {
    	return $this->belongsTo('\App\HRISDavaoPosition','PositionID','PositionID');
    }
}
