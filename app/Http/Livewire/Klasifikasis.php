<?php

namespace App\Http\Livewire;

use App\Models\Klasifikasi;
use Livewire\Component;

class Klasifikasis extends Component
{
    public $name, $selectedItem;

    protected $listeners =[
        'delete',
        'cancelled'
    ];

    public function selectemItem($itemId, $action)
    {

        $this->selectedItem = $itemId;

        if($action == 'delete'){
            // $this->dispatchBrowserEvent('openDeleteModal');
            $this->triggerConfirm();
           
            
        }else{
            $data = Klasifikasi::find($this->selectedItem);
            $this->name = $data->name;
        }
        
        // $this->action = $action;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|min:5'
        ]);
        $data = [
            'name' => $this->name
        ];

        $this->selectedItem ? $save = Klasifikasi::find($this->selectedItem)->update($data) : $save = Klasifikasi::create($data);
        $save ? $this->isSuccess("Data Created Successfully") : $this->isError("Data Created Successfully");
        
        $this->cleanVars();
    }
    public function delete()
    {
        $delete = Klasifikasi::destroy($this->selectedItem);
        $delete ? $this->isSuccess("Data Deleted Successfully") : $this->isError("Data Deleted Failed");
        $this->cleanVars();

    }

    public function render()
    {
        return view('livewire.klasifikasis',[
            'klasifikasis' => Klasifikasi::orderBy('name','ASC')->get()
        ]);
    }
    public function cleanVars()
    {
        $this->name = null;
        $this->selectedItem = null;
    }

    public function triggerConfirm()
    {
        $this->confirm('yakin menghapus data ini ?', [
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
