<?php

namespace App\Http\Livewire;

use App\Models\YearSelect;
use Livewire\Component;

class Wirehome extends Component
{
    public $year, $yearId;

    public function mount()
    {
        $year = YearSelect::latest()
        ->first();
        $this->year = $year->year;
        $this->yearId = $year->id;
    }
    public function render()
    {
        $last= date('Y')+20;
        $now = date('Y')-1;
        return view('livewire.wirehome',[
            'last' => $last,
            'now' => $now
        ]);
    }

    public function save()
    {
        $update = YearSelect::find($this->yearId)->update([
            'year' => $this->year
        ]);

        $this->isSuccess("updated!");
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


}
