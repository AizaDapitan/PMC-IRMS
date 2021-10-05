<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class ItemType extends Model implements AuditableContract
{
    use Auditable;
    protected $table = "types";
	protected $fillable = ['main', 'type', 'addedBy'];
    protected $auditInclude = ['main', 'type', 'addedBy'];
    public $timestamps = true;

    public function getLastDateModifiedAttribute()
    {
        return \Carbon\Carbon::parse($this->updated_at)->diffForHumans();
    }
}
