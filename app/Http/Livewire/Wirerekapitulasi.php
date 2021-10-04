<?php

namespace App\Http\Livewire;

use App\Exports\RekapitulasiExport;
use App\Models\Klasifikasi;
use App\Models\Report;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Wirerekapitulasi extends Component
{
    public $klasifikasi_id, $startDate, $endDate, $filterTahun, $monthStart, $monthEnd;

    public function mount()
    {
        $this->filterTahun = Carbon::now()->year;
        $this->monthStart = '01';
        $this->monthEnd = '12';
        $this->startDate = date($this->filterTahun.'/'.$this->monthStart.'/00');
        $this->endDate = date($this->filterTahun.'/'.$this->monthEnd.'/31');

        $this->klasifikasi_id = Klasifikasi::orderby('name', 'ASC')->first()->id;

        
    }
    public function resultData()
    {
        $haha = $this->klasifikasi_id;
        $this->startDate = date($this->filterTahun.'/'.$this->monthStart.'/00');
        $this->endDate = date($this->filterTahun.'/'.$this->monthEnd.'/31');

        return Report::rekapitulasi($haha, $this->startDate, $this->endDate)
            ->groupBy('penerimaan_id');
            // ->get()->sortby('penerimaan.barang_id');
    }
    public function render()
    {
        // dd($this->resultData());
        return view('livewire.wirerekapitulasi',[
            'reports' => $this->resultData(),
            'klasifikasis' => Klasifikasi::orderBy('name')->get(),

        ]);
    }
    public function exportToExcel()
    {
        return Excel::download(new RekapitulasiExport($this->resultData()), 'Rekapitulasi.xlsx');

    }
      public function exportToPdf()
    {
        return redirect()->to('/rekapitulasi/pdf/' . $this->klasifikasi_id . '/' . $this->filterTahun);
    }
}
