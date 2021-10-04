<?php

namespace App\Http\Livewire\PenerimaanOrder;

use App\Models\Barang;
use App\Models\Klasifikasi;
use App\Models\Order;
use App\Models\Satuan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $klasifikasi_id, $barang_id, $barang_price, $barang_qty, $barang_sisa = 0, $satuan_id, $satuan, $selectedItemId;
    public $isUpdate;

    protected $rules = [
        'barang_id' => 'required',
        'barang_price' => 'required',
        'barang_qty' => 'required',
        'barang_sisa' => 'nullable',
        'satuan_id' => 'required',
        
    ];
    protected $messages = [
        
        'barang_id' => 'this field is required.',
        'klasifikasi_id' => 'this field is required.',
        'satuan_id' => 'this field is required.',
        'barang_price' => 'this field is required.',
        'barang_qty' => 'this field is required.',
        'barang_sisa' => 'this field is required.',

    ];

    protected $listeners = [
        'cleanVars',
        'getModelId',
        'forceCloseModal',
    ];
    
    public function render()
    {
        if ($this->satuan_id != null) {
            $this->satuan= Satuan::find($this->satuan_id)->name;
           
        }
        $barangs = Barang::with('klasifikasi')->where('klasifikasi_id', $this->klasifikasi_id)->get();

        return view('livewire.penerimaan-order.create',[
            'klasifikasis' => Klasifikasi::orderby('name','ASC')->get(),
            'satuans' => Satuan::orderby('name','ASC')->get(),
            'barangs' => $barangs
        ]);
    }
    public function save()
    {
        $data  =  $this->validate();
        $data['user_id'] = Auth::user()->id;
        $save = $this->selectedItemId ? Order::find($this->selectedItemId)->update($data) : Order::create($data); 
        
        $save ? $this->emit('isSuccess',"Berhasil") : $this->emit('isError',"Terjadi kesalahan");
        $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal');
        $this->cleanVars();

    }

    public function getModelId($modelId)
     {
        $this->selectedItemId = $modelId;
        $model = Order::find($this->selectedItemId);
        $this->klasifikasi_id = Barang::find($model->barang_id)->klasifikasi_id;
        $this->barang_id = $model->barang_id;
        $this->satuan_id = $model->satuan_id;
        $this->barang_price = $model->barang_price;
        $this->barang_qty = $model->barang_qty;
        $this->barang_sisa = $model->barang_sisa;
     }

    public function cleanVars()
     {
         $this->barang_id = null;
         $this->satuan_id = null;
         $this->klasifikasi_id = null;
         $this->barang_price = null;
         $this->barang_qty = null;
     }
    
    public function forceCloseModal()
     {
         $this->cleanVars();
         $this->resetErrorBag();
         $this->resetValidation();
     }
}
