<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class internships extends Model
{
    //
    protected $table = 'internships';
    protected $guarded = [];

    public function students() {
        return $this->belongsTo(students::class, "student_id", "id");
    }

    public function reports() {
        return $this->hasMany(reports::class,"internship_id","id");
    }

    public function teacher() {
        return $this->belongsTo(  teachers::class,"teacher_id","id");
    }

    public function company() {
        return $this->belongsTo(companies::class, "company_id", "id");
    }

    public function supervisor() {
        return $this->belongsTo(supervisors::class,"supervisor_id","id");
    }
}
