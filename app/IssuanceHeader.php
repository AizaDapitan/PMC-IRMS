<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\IssuanceDetail;

class IssuanceHeader extends Model
{
    protected $table = "is_header";
	protected $fillable = ['controlNum', 'docDate', 'receiverId', 'receiver', 'position','isContractor', 'status', 'postedDate', 'isCompleted', 'addedBy','location','systemref','dept','contractorId'];
    public $timestamps = true;

    public function items()
    {
    	return $this->hasMany('\App\IssuanceDetail','headerId','id');
    }

    public function getRequestStatusAttribute()
    {
    	$qty = 0;
    	$released = 0;
    	foreach($this->items as $item){
    		$qty += $item->qty;
    		$released += $item->qtyReleased;
    	}
        if($this->status == 'C'){
            $status = '<span class="badge badge-roundless badge-danger">Cancelled</span>';
        } else {
            if($qty == $released){
                $status = '<span class="badge badge-roundless badge-success">Completed</span>';
            } else {
                $status = '';
            }
        }
    	
    	return $released.'/'.$qty.' '.$status;
    }

    public function getIssuanceStatusAttribute()
    {
        $qty = 0;
        $released = 0;
        foreach($this->items as $item){
            $qty += $item->qty;
            $released += $item->qtyReleased;
        }
        
        if($qty == $released){
            $status = 1;
        } else {
            $status = 0;
        }
        
        return $status;
    }
}
