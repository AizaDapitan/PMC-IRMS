<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Role extends Model implements AuditableContract
{
    use Auditable;
    protected $table = "roles";
	protected $fillable = ['name', 'description', 'active'];
    protected $auditInclude = ['name', 'description', 'active'];
    public $timestamps = true;

    public function getLastDateModifiedAttribute()
    {
        return \Carbon\Carbon::parse($this->updated_at)->diffForHumans();
    }
}
