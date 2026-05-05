<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konser extends Model
{
    protected $table = 'konsers';
    protected $primaryKey = 'id_concert';
    protected $fillable = ['nama_concert', 'tanggal', 'waktu', 'harga_dasar', 'id_venue'];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime:H:i:s',
    ];

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'id_venue', 'id_venue');
    }

    public function tikets()
    {
        return $this->hasMany(Tiket::class, 'id_concert');
    }
}