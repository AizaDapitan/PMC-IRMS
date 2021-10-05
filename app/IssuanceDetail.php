<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class IssuanceDetail extends Model implements AuditableContract
{
    use Auditable;
    protected $table = "is_detail";
	protected $fillable = ['headerId','itemDesc', 'itemColor', 'itemSize', 'qty', 'lastIssueDate','remarks', 'qtyReleased', 'refId', 'noPAR', 'systemref'];
    public $timestamps = true;
    protected $auditInclude = ['headerId','itemDesc', 'itemColor', 'itemSize', 'qty', 'lastIssueDate','remarks', 'qtyReleased', 'refId', 'noPAR', 'systemref'];
    
    public function header_details()
    {
    	return $this->belongsTo('\App\IssuanceHeader','headerId');
    }

    public function item_types()
    {
    	return $this->hasMany('\App\ItemType','itemDesc','main');
    }
}
