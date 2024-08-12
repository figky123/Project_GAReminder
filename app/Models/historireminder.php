<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriReminder extends Model
{
    use HasFactory;
    protected $table = 'historireminders';
    protected $fillable = ['id_reminder', 'id_penerbangan'];

    // Definisikan relasi 1-to-1 dengan model Reminder
    public function reminder()
    {
        return $this->belongsTo(Reminder::class, 'id_reminder');
    }

    // Definisikan relasi 1-to-1 dengan model Penerbangan
    public function penerbangan()
    {
        return $this->belongsTo(Penerbangan::class, 'id_penerbangan');
    }
}
