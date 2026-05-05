<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $table = 'venues';
    protected $primaryKey = 'id_venue';
    protected $fillable = ['nama_venue', 'alamat', 'kapasitas'];

    public function konsers()
    {
        return $this->hasMany(Konser::class, 'id_venue');
    }

    public function kursis()
    {
        return $this->hasMany(Kursi::class, 'id_venue', 'id_venue');
    }
}