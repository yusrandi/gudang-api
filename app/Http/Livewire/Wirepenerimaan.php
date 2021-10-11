<?php

namespace App\Http\Livewire;

use App\Exports\PenerimaansExport;
use App\Models\Klasifikasi;
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Models\Report;
use App\Models\YearSelect;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

class Wirepenerimaan extends Component
{
    public $filterKatid, $filterSemester, $monthStart, $monthEnd, $startDate, $endDate, $filterTahun, $selectedItemId;
    public $yearPriode;
    protected $listeners = [
        'confirmed',
        'cancelled',
        'delete',
        'isSuccess',
        'isError',
        'refreshParent'=>'$refresh'
    ];

    public function create()
    {
        return redirect()->to('penerimaan/create');
    }
    public function mount()
    {
        $this->filterTahun = Carbon::now()->year;
        $this->monthStart = '01';
        $this->monthEnd = '12';
        $this->startDate = date($this->filterTahun.'/'.$this->monthStart.'/00');
        $this->endDate = date($this->filterTahun.'/'.$this->monthEnd.'/31');
        $this->filterSemester = '01,12';
        // dd($this->startDate);

        $this->filterKatid = Klasifikasi::orderby('name', 'ASC')->first()->id;
        $this->yearPriode = YearSelect::latest()->first()->year;
        
    }
    private function resultData(){
        
        $haha = $this->filterKatid;

        $splitMonth = explode(',', $this->filterSemester, 2);
        $this->monthStart = $splitMonth[0];
        $this->monthEnd = $splitMonth[1];
        $this->startDate = date($this->filterTahun.'/'.$this->monthStart.'/00');
        $this->endDate = date($this->filterTahun.'/'.$this->monthEnd.'/31');
        $sortDirection = 'ASC';

        return Penerimaan::penerimaans($haha)
        ->WhereBetween('spk_date', [$this->startDate, $this->endDate])
        ->groupBy('spk_no');
        
    }

    public function exportToExcel()
    {
        return Excel::download(new PenerimaansExport($this->resultData()), 'penerimaan.xlsx');

    }
    public function exportToPdf()
    {

        return redirect()->to('/penerimaan/pdf/' . $this->filterKatid . '/' . $this->filterSemester . '/' . $this->filterTahun);

    }
    public function render()
    {
        // $penerimaans = Penerimaan::penerimaans()->groupBy('spk_no');
        $klasifikasis = Klasifikasi::orderby('name', 'ASC')->get();

        

        return view('livewire.wirepenerimaan',[
            'penerimaans' => $this->resultData(),
            'klasifikasis' => $klasifikasis,
            'count' => 0,
        ]);
    }

    public function delete()
    {
        $penerimaans = Penerimaan::find($this->selectedItemId);

        $delete = $penerimaans->manyreports()->delete();
        $delete = $penerimaans->manypengeluarans()->delete();
        
        if($delete){
            $penerimaans->delete();
            $this->isSuccess("Berhasil Mengahapus");
        }else{
            $this->isError("Terjai kesalahan, Gagal Mengahapus");

        }
    }

    public function selectedItem($item, $action)
    {
        $this->selectedItemId = $item;

        if($action == 'delete'){
            $this->triggerConfirm();
        }else{
            session()->flash('id', $item);
            return redirect()->to('/penerimaan/create');

        }
    }

    public function triggerConfirm()
    {
        $this->confirm('Do you wish to continue ?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'showCancelButton' =>  true, 
            'onConfirmed' => 'delete',
            'onCancelled' => 'cancelled'
        ]);
    }

    public function isSuccess($msg)
    {
        $this->alert('success', $msg, [
            'position' =>  'top-end', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Cancel', 
            'showCancelButton' =>  false, 
            'showConfirmButton' =>  false, 
      ]);
    }
    public function isError($msg)
    {
        $this->alert('error', $msg, [
            'position' =>  'top-end', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Cancel', 
            'showCancelButton' =>  false, 
            'showConfirmButton' =>  false, 
      ]);
    }
    public function confirmed()
    {
        // Example code inside confirmed callback
    
        $this->alert('success', 'Hello World!', [
            'position' =>  'top-end', 
            'timer' =>  3000,  
            'toast' =>  true, 
            'text' =>  '', 
            'confirmButtonText' =>  'Ok', 
            'cancelButtonText' =>  'Cancel', 
            'showCancelButton' =>  true, 
            'showConfirmButton' =>  true, 
      ]);
    }
    
    public function cancelled()
    {
        // Example code inside cancelled callback
    
        $this->alert('info', 'Understood');
    }
}
