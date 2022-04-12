<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Aset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_kategori', 'nama_kategori', 'foto_kategori'
    ];

    public function aset(){
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
