<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reports extends Model
{
    //
    protected $table = "reports";
    protected $guarded = ["id"];

    public function internship() {
        return $this->belongsTo(internships::class,"internship_id","id");
    }
}
