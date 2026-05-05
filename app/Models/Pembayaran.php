<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primaryKey = 'id_payment';
    public $timestamps = true;

    protected $fillable = [
        'metode_pembayaran',
        'jumlah',
        'tanggal_pembayaran',
        'status_pembayaran',
    ];
}