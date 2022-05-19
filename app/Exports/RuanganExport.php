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
    public function __construct(String $ruangan)
    {
        $this->ruangan = $ruangan;
    }

    public function query()
    {
        return Aset::query()
        ->select('id_aset', 'nama_aset', 'gedung', 'ruangan', 'kondisi', 'keterangan', 'harga_beli', 'harga_jual')
        ->where('ruangan', 'like', '%'. $this->ruangan . '%')
        ->orderBy('id_aset', 'asc');
    }

    public function headings(): array
    {
        return ["Id Aset", "Nama Aset", "Gedung", "Ruangan", "Kondisi", "Keterangan", "Harga Beli", "Harga Jual"];
    }
}
