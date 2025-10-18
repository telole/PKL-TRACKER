<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class teachers extends Model
{
    //

    protected $table = "teachers";
    protected $guarded = ['id'];
    public $timestamps = false;


    public function Users() {
        return $this->hasMany(User::class);
    }

    public function Internships() {
        return $this->hasMany(internships::class);
    }
}
