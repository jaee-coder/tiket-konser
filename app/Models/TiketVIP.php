<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketVIP extends Model
{
    protected $table = 'tiket_vips';
    public $timestamps = false;
    protected $primaryKey = 'id_ticket';
    public $incrementing = false;
    protected $fillable = ['id_ticket', 'akses_vip', 'fasilitas_tambahan'];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'id_ticket');
    }
}