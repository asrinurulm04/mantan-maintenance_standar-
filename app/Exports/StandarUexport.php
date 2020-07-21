<?php

namespace App\Exports;
use App\Model\Standar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class StandarUexport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
  
    public function __construct(string $nama_item,string $kode_oracle,string $stok_rnd,string $tgl_datang,string $tgl_dibuat,string $tgl_kadaluarsa)
    {
        $this->nama_item = $nama_item;
        $this->kode_oracle = $kode_oracle;
        $this->stok_rnd = $stok_rnd;
        $this->tgl_datang = $tgl_datang;
        $this->tgl_dibuat = $tgl_dibuat;
        $this->tgl_kadaluarsa = $tgl_kadaluarsa;
    }

    public function query()
    {
        return Standar::all();
    }
}
