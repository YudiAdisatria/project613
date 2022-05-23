<?php

namespace App\Exports;

use App\Models\Aset;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;


class RuanganExport implements FromQuery, WithHeadings
{
    use Exportable;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(String $gedung, String $ruangan, String $kondisi, String $kategori)
    {
        $this->gedung = $gedung;
        $this->ruangan = $ruangan;
        $this->kondisi = $kondisi;
        $this->kategori = $kategori;
    }

    public function query()
    {
        return Aset::query()
        ->select('id_aset', 'nama_aset', 'gedung', 'ruangan', 'kondisi', 'keterangan', 'harga_beli', 'harga_jual')
        ->where('gedung', 'like', '%'. $this->gedung . '%')
        ->where('ruangan', 'like', '%'. $this->ruangan . '%')
        ->where('kondisi', 'like', '%'. $this->kondisi . '%')
        ->where('id_kategori', 'like', '%'. $this->kategori . '%')
        ->orderBy('id_aset', 'asc');
    }

    public function headings(): array
    {
        return ["Id Aset", "Nama Aset", "Gedung", "Ruangan", "Kondisi", "Keterangan", "Harga Beli", "Harga Jual"];
    }
}
