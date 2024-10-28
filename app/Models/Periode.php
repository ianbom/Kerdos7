<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;

    protected $guarded = ['id_periode'];
    protected $table = 'periode';
    protected $primaryKey = 'id_periode';

    public function pengajuan(){
        return $this->hasMany(Pengajuan::class, 'id_periode', 'id_periode');
    }

    public function bkd()
    {
        return $this->hasMany(Bkd::class, 'id_periode', 'id_periode');
    }

    public function parentPeriode()
    {
    return $this->belongsTo(Periode::class, 'id_child', 'id_periode');
        }
}
