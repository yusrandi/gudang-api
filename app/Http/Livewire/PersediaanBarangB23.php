<?php

namespace App\Http\Livewire;

use App\Exports\PersediaanBarangB23Export;
use App\Models\Klasifikasi;
use App\Models\Report;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class PersediaanBarangB23 extends Component
{
    public $filterTahun, $monthStart, $monthEnd, $startDate, $endDate, $klasifikasi_id;

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

        return Report::with('penerimaan')
            ->orderBy('barang_id')
            // ->where(function ($query){
            
            //     if($this->klasifikasi_id != null){
            //         $query->Where('klasifikasi_id', $this->klasifikasi_id);
            //     }
            
            // })
            ->whereHas('penerimaan.barang', function($q) use($haha) {
            
            if($haha != null){
                $q->where('klasifikasi_id', $haha);
            }
            
            })
            ->WhereBetween('date', [$this->startDate, $this->endDate])
            ->get()->sortby('penerimaan.barang_id');
    }
    public function render()
    {
        // dd($this->resultData());
        return view('livewire.persediaan-barang-b23',[
            'klasifikasis' => Klasifikasi::orderBy('name')->get(),
            'reports' => $this->resultData(),
            'sisa' => 0,
            'barang_id' => 0,
        ]);
    }

    public function exportToExcel()
    {
        return Excel::download(new PersediaanBarangB23Export($this->resultData()), 'PersediaanBarangB23.xls');

    }
      public function exportToPdf()
    {
        return redirect()->to('/persediaanbarang/b23/pdf/' . $this->klasifikasi_id . '/' . $this->filterTahun);
    }
    
}
