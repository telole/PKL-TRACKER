<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class photos extends Model
{
    //
    protected $table = "photos";
    protected $guarded = [];

    public function users(){

        return $this->belongsTo(User::class,"uploaded_by","id");
    }
    
}
