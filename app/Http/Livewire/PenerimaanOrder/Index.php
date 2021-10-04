<?php

namespace App\Http\Livewire\PenerimaanOrder;

use App\Models\Order;
use App\Models\Penerimaan;
use App\Models\Rekanan;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;
    public $selectedItemId, $rekanan_id, $spk_file, $spk_date, $spk_no, $spm_file, $spm_date, $spm_no;
    public $barang_id, $barang_qty, $barang_price, $barang_sisa;
    public $satuan_id, $todayDate;
    public $spk_date_label;
    public $isUpdate = false;

    protected $listeners = [
        'confirmed',
        'cancelled',
        'delete',
        'isSuccess',
        'isError',
        'refreshParent'=>'$refresh',
        'isUpdate'
    ];

    protected $rules = [
        'rekanan_id' => 'required',
        'spk_file' => 'nullable|max:1024',
        'spk_date' => 'required',
        'spk_no' => 'required|unique:penerimaans',
        'spm_file' => 'nullable|max:1024',
        'spm_date' => 'nullable',
        'spm_no' => 'nullable',
    ];
    protected $messages = [
        'rekanan_id.required' => 'this field is required.',
        'spk_file.required' => 'this field is required.',
        'spk_date.required' => 'this field is required.',
        'spk_no.required' => 'this field is required.',
        'spm_date.required' => 'this field is required.',
        'spm_no.required' => 'this field is required.',
    ];


    public function checkUpdate()
    {
        return $this->isUpdate;
    }
    
    public function mount($id)
    {
        if ($id) {
            $this->isUpdate = true;
            $penerimaan = Penerimaan::find($id);
            $this->spk_no = $penerimaan->spk_no;
            $this->spk_date = $penerimaan->spk_date;
            $this->spk_date_label = $penerimaan->spk_date;
            $this->rekanan_id = $penerimaan->rekanan_id;
            $orders = Penerimaan::where('spk_no', $this->spk_no)->get();
            // dd($orders);
            foreach ($orders as $key => $value) {
                Order::create([
                    'barang_id' => $value->barang_id,
                    'satuan_id' => $value->satuan_id,
                    'barang_price' => $value->barang_price,
                    'barang_qty' => $value->barang_qty,
                    'barang_sisa' => $value->barang_sisa,
                    'status' => 1,
                    'user_id' => Auth::user()->id,
                    'penerimaan_id' => $value->id,
                ]);
            }
        }
        
    }
    public function create()
    {
        $this->emit('cleanVars');
        $this->dispatchBrowserEvent('openModal');
    }
    public function selectedItem($item, $action)
    {
        $this->selectedItemId = $item;

        if($action == 'delete'){
            $this->triggerConfirm();
        }else{
            $this->emit('getModelId',$this->selectedItemId);
            $this->dispatchBrowserEvent('openModal');
        }
    }
    public function delete()
    {
        $delete = Order::destroy($this->selectedItemId);
        if($delete){
            $this->isSuccess("Berhasil Mengahapus");
        }else{
            $this->isError("Terjai kesalahan, Gagal Mengahapus");

        }
    }

    public function render()
    {
        $orders = Order::with(['satuan','barang'])->where(['user_id' => Auth::user()->id, 'status' => 1])->get();
        return view('livewire.penerimaan-order.index',[
            'rekanans' => Rekanan::orderby('name','ASC')->get(),
            'orders' => $orders,
            'total' => 0
        ]);
    }

    public function submitall()
    {
        $todayDate = date('Y/m/d');
       
        $validateData = [];

        $validateData = array_merge($validateData,[
            'spk_date' => 'required|date_format:Y/m/d|before_or_equal:'.$todayDate,
            'rekanan_id' => 'required',
            'spk_file' => 'required|max:1024',
            'spk_no' => 'required|unique:penerimaans',
            'spm_file' => 'nullable|max:1024',
            'spm_date' => 'nullable',
            'spm_no' => 'nullable',
        ]);
        if ($this->isUpdate) {
            $validateData = array_merge($validateData,[
            'spk_file' => 'nullable|max:1024',
            'spk_no' => 'nullable',
            ]);
        }

        $data = $this->validate($validateData);
        $orders = Order::with(['satuan','barang'])->where(['user_id' => Auth::user()->id, 'status' => 1])->get();

        if (count($orders) > 0) {
           
                if (!empty($this->spk_file)) {
                    $this->spk_file->store('public/spk_file');
                    $spkName = $this->spk_file->hashName();
                    $data['spk_file'] = $spkName;
                }
                if (!empty($this->spm_file)) {
                    $this->spk_file->store('public/spm_file');
                    $spkName = $this->spk_file->hashName();
                    $data['spm_file'] = $spkName;
                }

                foreach ($orders as $key => $value) {
                
                    $data['barang_id'] = $value->barang_id;
                    $data['barang_price'] = $value->barang_price;
                    $data['barang_qty'] = $value->barang_qty;
                    
                    $data['satuan_id'] = $value->satuan_id;

                    if ($this->isUpdate) {
                        
                        $data['barang_sisa'] = $value->barang_sisa;
                        $penerimaan = Penerimaan::find($value->penerimaan_id);
                        if ($penerimaan) {
                            $save = $penerimaan->update($data);
                            $msg = 'Data Berhasil Diubah';
                        }else{
                            $save = Penerimaan::create($data);
                            $msg = 'Data Berhasil Ditambahkan';
                        }

                    }else{
                        $data['barang_sisa'] = $value->barang_qty;
                        $msg = 'Data Berhasil Ditambahkan';
                        $save = Penerimaan::create($data);
                        $save ? Order::destroy($value->id) : $this->isError("Data Gagal ditambahkan");

                        $dataReport = [
                            'date' => $save->spk_date,
                            'penerimaan_id' => $save->id,
                            'barang_id' => $save->barang_id,
                            'qty' => $save->barang_qty,
                            'sisa' => $save->barang_qty,
                        ];
                        Report::create($dataReport);
                    }
                    
                    $value->delete();
                    
                }

            $save ? $this->isSuccess("Success") : $this->isError("Failed");
            session()->flash('message', $msg);
            return redirect()->to('/penerimaan');
            
        }else{
            $this->isError('Harap Mengisi Keranjang Terlebih Dahulu');
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
