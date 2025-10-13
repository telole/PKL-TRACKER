<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class companies extends Model
{
    //
    protected $table = "companies";
    protected $guarded = [];

    public function supervisors() {
        return $this->hasMany(supervisors::class, "company_id", "id");
    }

    public function internship() {
        return $this->hasMany(internships::class, "company_id", "id");
    }
}
