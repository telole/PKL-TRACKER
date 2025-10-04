<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class audit extends Model
{
    //
    protected $table = "audit_logs";

    protected $guareded = [];

    public function users() {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
