<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reminder extends Model
{
    use HasFactory;
    protected $table = 'reminders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'no_hp',
        'isi_pesan',
        'status_tiket',
        'ket_pesan',
        'tgl_berangkat',
        'gambar_pesan',
    ];

    public function historiReminder()
    {
        return $this->hasOne(HistoriReminder::class, 'id_penerbangan');
    }
}
