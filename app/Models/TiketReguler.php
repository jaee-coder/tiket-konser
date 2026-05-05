<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketReguler extends Model
{
    protected $table = 'tiket_regulers';
    public $timestamps = false;
    protected $primaryKey = 'id_ticket';
    public $incrementing = false;
    protected $fillable = ['id_ticket', 'zona'];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'id_ticket');
    }
}