<?php

namespace App\Exports;

use App\Standar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
class StandarWIPExport implements FromView
{
    use Exportable;
    public function __construct(string $jenis_item_id)
    {
        $this->jenis_item_id = $jenis_item_id;
    }
      
    public function view(): View
    {
        return view('excel.data_wip', [
            'standar' => Standar::where('jenis_item_id','like', '%'.$this->jenis_item_id.'%')->get()
        ]);
    }
}
