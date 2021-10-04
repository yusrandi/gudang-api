<?php

namespace App\Http\Livewire;

use App\Exports\PengeluaranExport;
use App\Models\Bagian;
use App\Models\Klasifikasi;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Wirepengeluaran extends Component
{
    public $filterBagianId, $filterSemester, $monthStart, $monthEnd, $startDate, $endDate, $filterTahun, $filterKatid;

    public $selectedItemId;

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
        return redirect()->to('pengeluaran/create');
    }
    public function mount()
    {
        $this->filterTahun = Carbon::now()->year;
        $this->monthStart = '01';
        $this->monthEnd = '12';
        $this->startDate = date($this->filterTahun.'/'.$this->monthStart.'/00');
        $this->endDate = date($this->filterTahun.'/'.$this->monthEnd.'/28');
        $this->filterSemester = '01,12';
        // dd($this->startDate);
        $this->filterKatid = Klasifikasi::orderby('name', 'ASC')->first()->id;
        
    }

    private function resultData(){
        
        $haha = $this->filterKatid;
        $splitMonth = explode(',', $this->filterSemester, 2);
        $this->monthStart = $splitMonth[0];
        $this->monthEnd = $splitMonth[1];
        $this->startDate = date($this->filterTahun.'/'.$this->monthStart.'/00');
        $this->endDate = date($this->filterTahun.'/'.$this->monthEnd.'/28');
        $sortDirection = 'ASC';

        if ($this->filterBagianId != null) {
           return Pengeluaran::pengeluarans($haha, $this->filterBagianId)
                ->WhereBetween('date', [$this->startDate, $this->endDate])
                ->where('bagian_id', $this->filterBagianId)
                ->groupBy('nota_no');
        }else{
            return Pengeluaran::pengeluarans($haha, $this->filterBagianId)
                ->WhereBetween('date', [$this->startDate, $this->endDate])
                ->groupBy('nota_no');
        }
        
        
    }

    public function exportToExcel()
    {
        return Excel::download(new PengeluaranExport($this->resultData()), 'pengeluaran.xlsx');

    }
    public function exportToPdf()
    {

        return redirect()->to('/pengeluaran/pdf/' . $this->filterKatid . '/' . $this->filterSemester . '/' . $this->filterTahun);

    }
    public function render()
    {
        return view('livewire.wirepengeluaran',[
            'klasifikasis' => Klasifikasi::orderby('name','asc')->get(),
            'bagians' => Bagian::orderby('name','asc')->get(),
            'pengeluarans' => $this->resultData(),
            'count' => 0,
            'total' => 0
        ]);
    }

    public function delete()
    {
        
        $delete = Pengeluaran::destroy($this->selectedItemId);
        
        if($delete){
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
            return redirect()->to('/pengeluaran/create');

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
