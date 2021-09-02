<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipCity extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function state(){
    	return $this->belongsTo(ShipState::class,'state_id','id');
    }

     public function district(){
    	return $this->belongsTo(ShipDistrict::class,'district_id','id');
    }
}
