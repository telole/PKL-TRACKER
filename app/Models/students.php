<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    //
    protected $table = "student";

    protected $guarded = ['id'];


    public function users() {
        return $this->belongsTo(User::class,"user_id",'id');
    }

    public function internshps() { 
        return $this->hasMany(internships::class,'student_id','id');
    }
}
