<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Aset;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_history', 'id_pemindah', 'id_aset', 'lokasi_lama',
        'lokasi_baru', 'keterangan', 
    ];

    public function aset(){
        return $this->hasMany(Aset::class,'id_aset', 'id_aset');
    }

    public function user(){
        return $this->belongsTo(User::class,'id_pemindah', 'noHp');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }
}
