<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssuanceDetail extends Model
{
    protected $table = "is_detail";
	protected $fillable = ['headerId','itemDesc', 'itemColor', 'itemSize', 'qty', 'lastIssueDate','remarks', 'qtyReleased', 'refId', 'noPAR', 'systemref'];
    public $timestamps = true;

    public function header_details()
    {
    	return $this->belongsTo('\App\IssuanceHeader','headerId');
    }

    public function item_types()
    {
    	return $this->hasMany('\App\ItemType','itemDesc','main');
    }
}
