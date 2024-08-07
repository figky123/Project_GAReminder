<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penerbangan extends Model
{
    use HasFactory;
    protected $table = 'penerbangans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_penerbangan',
        'nomor_penerbangan',
        'rute_penerbangan',
        'jam_penerbangan'
    ];
    
    public function historiReminder()
    {
        return $this->hasOne(HistoriReminder::class, 'id_reminder');
    }
}
