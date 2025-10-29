<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class supervisors extends Model
{
    //
    protected $guarded = [];
    protected $table = "supervisors";


    public function companies() {
        return $this->belongsTo(companies::class, "company_id", "id");
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
