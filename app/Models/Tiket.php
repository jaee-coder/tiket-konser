<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    protected $table = 'tikets';
    protected $primaryKey = 'id_ticket';
    protected $fillable = [
        'kode_tiket', 'status', 'tanggal_pembelian', 'harga_jual',
        'id_concert', 'id_customer', 'id_payment', 'tipe', 'nomor_kursi'
    ];

    public function konser()
    {
        return $this->belongsTo(Konser::class, 'id_concert');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_customer');
    }
}