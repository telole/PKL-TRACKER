<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    // /**
    //  * The attributes that are mass assignable.
    //  *
    //  * @var list<string>
    //  */
    // // protected $fillable = [
    // //     'name',
    // //     'email',
    // //     'password',
    // // ];

    // /**
    //  * The attributes that should be hidden for serialization.
    //  *
    //  * @var list<string>
    //  */
    // // protected $hidden = [
    // //     'password',
    // //     'remember_token',
    // // ];

    // /**
    //  * Get the attributes that should be cast.
    //  *
    //  * @return array<string, string>
    //  */
    // // protected function casts(): array
    // // {
    // //     return [
    // //         'email_verified_at' => 'datetime',
    // //         'password' => 'hashed',
    // //     ];
    // // }


    protected $table = 'users';

    protected $guarded = ['id'];

    protected $hidden = [
        "password_hash","updated_at", "created_at", "id", "last_login"
    ];

    public function teachers(){
        return $this->hasMany(teachers::class);
    }

    public function student() {
        return $this->hasOne(students::class);
    }

    public function audit() {
        return $this->hasMany(Audit::class);
    }


    public function notification() {
        return $this->hasMany(Notification::class);
    }

    public function photos() {
        return $this->hasMany(photos::class);
    }


    public function supervisors() {
        return $this->hasMany(supervisors::class);
    }
}
