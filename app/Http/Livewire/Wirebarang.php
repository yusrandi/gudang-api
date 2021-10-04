<?php

namespace App\Http\Livewire;

use App\Models\Barang;
use App\Models\Klasifikasi;
use Livewire\Component;

class Wirebarang extends Component
{
    public $name, $klasifikasi_id, $selectedItem;

    protected $listeners =[
        'delete',
        'cancelled'
    ];
    
    protected $rules = [
        'name' => 'required',
        'klasifikasi_id' => 'required',
        
    ];
    protected $messages = [
        'name.required' => 'this field is required.',
        'klasifikasi_id.required' => 'this field is required.',
    ];

    public function render()
    {
        return view('livewire.wirebarang',[
            'barangs' => Barang::with('klasifikasi')->orderBy('klasifikasi_id','ASC')->get(),
            'klasifikasis' => Klasifikasi::orderby('name','ASC')->get()
        ]);
    }
    public function selectemItem($itemId, $action)
    {

        $this->selectedItem = $itemId;

        if($action == 'delete'){
            // $this->dispatchBrowserEvent('openDeleteModal');
            $this->triggerConfirm();
           
            
        }else{
            $data = Barang::find($this->selectedItem);
            $this->name = $data->name;
            $this->klasifikasi_id = $data->klasifikasi_id;
        }
        
        // $this->action = $action;
    }

    public function save()
    {
        $data = $this->validate();
         
        $this->selectedItem ? $save = Barang::find($this->selectedItem)->update($data) : $save = Barang::create($data);
        $save ? $this->isSuccess("Data Created Successfully") : $this->isError("Data Created Successfully");
        
        $this->cleanVars();
    }
    public function delete()
    {
        $delete = Barang::destroy($this->selectedItem);
        $delete ? $this->isSuccess("Data Deleted Successfully") : $this->isError("Data Deleted Failed");
        $this->cleanVars();
    }

    public function cleanVars()
    {
        $this->name = null;
        $this->klasifikasi_id = null;
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
