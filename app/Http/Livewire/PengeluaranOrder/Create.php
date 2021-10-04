<?php

namespace App\Http\Livewire\PengeluaranOrder;

use App\Models\Barang;
use App\Models\Klasifikasi;
use App\Models\Order;
use App\Models\Penerimaan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $klasifikasi_id, $barang_id, $qty;
    public $selectedItemId;

    protected $listeners = [
        'cleanVars',
        'getModelId',
        'forceCloseModal',
    ];

    public function selectedItem($id, $index)
    {
       
        $dataBarang = Penerimaan::find($id);
        $barang_sisa = $dataBarang->barang_sisa;
        
        if (!isset($this->qty)) {
            $this->isError("Jumlahnya di isi dlu bang");
        }else if($this->qty[$index] > $barang_sisa){
            $this->isError("Jumlah melebihi stok bang");
        }else {

            
            $data = [
                    'barang_id' => $dataBarang->barang_id,
                    'satuan_id' => $dataBarang->satuan_id,
                    'barang_price' => $dataBarang->barang_price,
                    'barang_qty' => $this->qty[$index],
                    'status' => 2,
                    'user_id' => Auth::user()->id,
                    'penerimaan_id' => $id,
            ];
            if ($this->selectedItemId) {
                
                $stok = $dataBarang->barang_sisa;
                $stokUpdate = $stok - $this->qty[$index];
                $data['barang_sisa'] = $stokUpdate;

                $save = Order::find($this->selectedItemId)->update($data);

            }else{
                $save = Order::create($data) ;
            }
            $save ? $this->emit('isSuccess',"Berhasil") : $this->emit('isError',"Terjadi kesalahan");

            $this->emit('refreshParent');
            $this->dispatchBrowserEvent('closeModal');
            $this->cleanVars();
            
        }
        
    }

    public function render()
    {
        $klasifikasi_id = $this->klasifikasi_id;
        $penerimaans = Penerimaan::with(['barang','satuan','rekanan'])
        ->where('barang_sisa', '!=', 0)
        ->whereHas('barang', function($q) use($klasifikasi_id) {
            if($this->klasifikasi_id != null){
                $q->where('klasifikasi_id', $klasifikasi_id);
            }
        })
        ->get()->sortByDesc('barang.klasifikasi_id');

        $data = Penerimaan::where('barang_id', $this->barang_id)
        // ->doesntHave('orders')
        ->get();

        return view('livewire.pengeluaran-order.create',[
            'klasifikasis' => Klasifikasi::orderby('name','ASC')->get(),
            'barangs' => Barang::where('klasifikasi_id', $this->klasifikasi_id)->orderby('name','ASC')->get(),
            'datas' => $data,
        ]);
    }

    public function getModelId($modelId)
     {
        $this->selectedItemId = $modelId;
        $model = Order::find($this->selectedItemId);
        $this->klasifikasi_id = Barang::find($model->barang_id)->klasifikasi_id;
        $this->barang_id = $model->barang_id;
        $this->barang_qty = $model->barang_qty;
     }

    public function cleanVars()
     {
         $this->klasifikasi_id = null;
         $this->barang_id = null;
         $this->qty = null;
     }
    
    public function forceCloseModal()
     {
         $this->cleanVars();
         $this->resetErrorBag();
         $this->resetValidation();
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
}
