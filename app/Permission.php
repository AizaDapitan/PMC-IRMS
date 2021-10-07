<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Permission extends Model implements AuditableContract
{
    use Auditable;
    protected $table = "permissions";
    protected $fillable = ['module_type', 'description', 'active'];
    public $timestamps = true;

    protected $auditInclude = [
        'module_type', 'description', 'active'
    ];
    public function getLastDateModifiedAttribute()
    {
        return \Carbon\Carbon::parse($this->updated_at)->diffForHumans();
    }
}
