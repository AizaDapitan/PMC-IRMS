<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";
	protected $fillable = ['name', 'description', 'active'];
    public $timestamps = true;

    public function getLastDateModifiedAttribute()
    {
        return \Carbon\Carbon::parse($this->updated_at)->diffForHumans();
    }
}
