<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $table = "category";
	protected $fillable = ['category', 'addedBy'];
    public $timestamps = true;

    public function getLastDateModifiedAttribute()
    {
        return \Carbon\Carbon::parse($this->updated_at)->diffForHumans();
    }
}
