<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_aset', 'id_kategori', 'nama_aset', 'hari_aset',
        'jam_aset', 'keterangan', 'foto_aset'
    ];

    public function aset(){
                            //class mana, fk class, fk sini
        return $this->hasMany(Pinjam::class,'id_aset', 'id_aset');
    }

    public function kategori(){
        //class mana, fk class, fk sini
    return $this->belongsTo(Kategori::class,'id_kategori', 'id_kategori');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getFotoAsetAttribute(){
        return url('') . Storage::url($this->attributes['foto_aset']);
    }
}
