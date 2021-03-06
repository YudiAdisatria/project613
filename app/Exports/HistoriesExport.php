<?php

namespace App\Exports;

use App\Models\History;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistoriesExport implements FromQuery, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(String $tanggal)
    {
        $this->tanggal = $tanggal;
    }

    public function query()
    {
        return History::query()
        ->select('id_history', 'id_pemindah', 'id_aset', 'lokasi_lama', 'lokasi_baru', 'keterangan', 'jenis_pindah')
        ->where('created_at', 'like', '%'. $this->tanggal . '%')
        ->orderBy('id_history', 'asc');
    }

    public function headings(): array
    {
        return ["Id History", "NoHP Pemindah", "Id Aset", "Lokasi Lama", "Lokasi Baru", "Keterangan", "Pindah/Jual"];
    }
}
