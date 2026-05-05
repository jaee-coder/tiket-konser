<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kursi extends Model
{
    protected $table = 'kursis';
    public $timestamps = false;
    protected $primaryKey = null;
    public $incrementing = false;
    protected $fillable = ['id_venue', 'nomor_kursi', 'baris', 'tipe_kursi', 'status'];

    public function venue()
    {
        return $this->belongsTo(Venue::class, 'id_venue', 'id_venue');
    }
}