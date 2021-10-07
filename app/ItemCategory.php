<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class ItemCategory extends Model implements AuditableContract
{
    use Auditable;
    protected $table = "category";
	protected $fillable = ['category', 'addedBy'];
    protected $auditInclude = ['category', 'addedBy'];
    public $timestamps = true;

    public function getLastDateModifiedAttribute()
    {
        return \Carbon\Carbon::parse($this->updated_at)->diffForHumans();
    }
}
