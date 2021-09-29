<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HRISAgusanEmployee extends Model
{
    protected $connection = "sqlsrv_agn_hris";
    protected $table = 'viewhrempmaster';

    public function deptDetails()
    {
    	return $this->belongsTo('\App\HRISAgusanDepartment','DeptID','DeptID');
    }

    public function positionDetails()
    {
    	return $this->belongsTo('\App\HRISAgusanPosition','PositionID','PositionID');
    }

    public function getFullNameAttribute()
    {
        return "$this->LName, $this->FName $this->MName";
    }

    public static function agusanEmployees()
    {
        $datas = HRISAgusanEmployee::get();

        $names = "";
        foreach($datas as $data)
        {
            $names .= $data->LName.'|';
        }
        return $names;
    }
}
