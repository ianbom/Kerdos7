<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Span_Dosen extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_span_dosen';
    protected $table = 'span_dosen';
    protected $guarded = ['id_span_dosen'];

    public function user(){
        return $this->belongsTo(User::class, 'id', 'id');
    }
}