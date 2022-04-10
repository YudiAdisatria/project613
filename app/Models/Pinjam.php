<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjam extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_pinjam', 'id_peminjam', 'id_validator', 'id_aset',
        'hari', 'durasi', 'keterangan'
    ];

    public function user(){
                            //class mana, fk class, fk sini
        return $this->belongsTo(user::class,'noHp', 'id_peminjam');
    }

    public function validator(){
        //class mana, fk class, fk sini
    return $this->belongsTo(user::class,'noHp', 'id_validator');
    }

    public function aset(){
        //class mana, fk class, fk sini
    return $this->belongsTo(Aset::class,'id_aset', 'id_aset');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }
}
