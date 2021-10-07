<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable  as AuditableContract;
use OwenIt\Auditing\Auditable;

class Module extends Model implements AuditableContract
{    
    use Auditable;
    protected $table = "modules";
	protected $fillable = ['description'];
    public $timestamps = true;
    protected $auditInclude = ['description'];

}
