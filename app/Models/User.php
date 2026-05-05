<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable {
// Di dalam class User
protected $fillable = [
    'name',
    'email',
    'password',
    'telepon',
    'id_referred_by',
];

public function referrer()
{
    return $this->belongsTo(User::class, 'id_referred_by');
}

public function referrals()
{
    return $this->hasMany(User::class, 'id_referred_by');
}

public function tikets()
{
    return $this->hasMany(Tiket::class, 'id_customer');
}
}
