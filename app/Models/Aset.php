<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\History;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Aset extends Model
{
    use HasFactory, SofDeletes;

    protected $fillable = [
        'id_aset', 'id_kategori', 'nama_aset', 'gedung',
        'ruangan', 'kondisi', 'keterangan', 'harga_beli', 'harga_jual', 
        'foto_aset',
    ];

    public function history(){
                            //class mana, fk class, fk sini
        return $this->hasMany(History::class,'id_aset', 'id_aset');
    }

    public function kategori(){
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
