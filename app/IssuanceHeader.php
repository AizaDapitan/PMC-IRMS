<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

use App\IssuanceDetail;

class IssuanceHeader extends Model implements AuditableContract
{
    use Auditable;
    protected $table = "is_header";
	protected $fillable = ['controlNum', 'docDate', 'receiverId', 'receiver', 'position','isContractor', 'status', 'postedDate', 'isCompleted', 'addedBy','location','systemref','dept','contractorId'];
    public $timestamps = true;
    protected $auditInclude = ['controlNum', 'docDate', 'receiverId', 'receiver', 'position','isContractor', 'status', 'postedDate', 'isCompleted', 'addedBy','location','systemref','dept','contractorId'];
    
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
