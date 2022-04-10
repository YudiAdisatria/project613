<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_kategori', 'nama_kategori', 'foto_kategori'
    ];

    public function kategori(){
        //class mana, fk class, fk sini
    return $this->hasMany(Aset::class,'id_kategori', 'id_kategori');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getFotoKategoriAttribute(){
        return url('') . Storage::url($this->attributes['foto_kategori']);
    }
}
