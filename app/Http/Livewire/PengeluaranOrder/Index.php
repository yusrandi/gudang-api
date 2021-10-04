<?php

namespace App\Http\Livewire\PengeluaranOrder;

use App\Models\Bagian;
use App\Models\Order;
use App\Models\Penerimaan;
use App\Models\Pengeluaran;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithFileUploads;
    public $date, $date_label, $bagian_id, $penanggung = 'Sudirman P, Amd.Kom', $penerima, $nota_no, $nota_file, $selectedItemId;
    public $isUpdate;

    protected $listeners = [
        'confirmed',
        'cancelled',
        'delete',
        'isSuccess',
        'isError',
        'refreshParent'=>'$refresh'
    ];

    protected $rules = [
        'date' => 'required',
        'bagian_id' => 'required',
        'penanggung' => 'required',
        'penerima' => 'required',
        'nota_no' => 'required',
        'nota_file' => 'required|max:5000',
    ];
    protected $messages = [
        'date.required' => 'this field is required.',
        'bagian_id.required' => 'this field is required.',
        'penanggung.required' => 'this field is required.',
        'penerima.required' => 'this field is required.',
        'nota_no.required' => 'this field is required.',
        'nota_file.required' => 'this field is required.',
    ];

    public function create()
    {
        $this->emit('cleanVars');
        $this->dispatchBrowserEvent('openModal');
    }
    public function mount($id)
    {
        if ($id) {
            $this->isUpdate = true;
            $pengeluaran = Pengeluaran::find($id);
            $this->date = $pengeluaran->date;
            $this->date_label = $pengeluaran->date;
            $this->bagian_id = $pengeluaran->bagian_id;
            $this->penanggung = $pengeluaran->penanggung;
            $this->penerima = $pengeluaran->penerima;
            $this->nota_no = $pengeluaran->nota_no;
            $orders = $pengeluaran->where('nota_no', $pengeluaran->nota_no)->get();
            // dd($orders);
            foreach ($orders as $key => $value) {
                Order::create([
                    'id' => $value->id,
                    'barang_id' => $value->penerimaan->barang_id,
                    'satuan_id' => $value->penerimaan->satuan_id,
                    'barang_price' => $value->penerimaan->barang_price,
                    'barang_qty' => $value->qty,
                    'barang_sisa' => $value->sisa,
                    'status' => 2,
                    'user_id' => Auth::user()->id,
                    'penerimaan_id' => $value->penerimaan_id,
                ]);
            }
            
        }
        
    }
    public function render()
    {
        return view('livewire.pengeluaran-order.index',[
            'bagians' => Bagian::orderby('name','ASC')->get(),
            'orders' => Order::with(['barang','satuan'])->where(['user_id' => Auth::user()->id, 'status' => 2])->get(),
            'total' => 0

        ]);
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

    public function submitall()
    {
        $todayDate = date('Y/m/d');
       
        $validateData = [];
        $validateData = array_merge($validateData,[
            'date' => 'required|date_format:Y/m/d|before_or_equal:'.$todayDate,
            'bagian_id' => 'required',
            'penanggung' => 'required',
            'penerima' => 'required',
            'nota_no' => 'required',
            'nota_file' => 'nullable|max:5000',
        ]);

        $data = $this->validate($validateData);

        $orders = Order::where(['user_id' => Auth::user()->id, 'status'=> 2])->get();
        
        if (count($orders) > 0) {
           

            if (!empty($this->nota_file)) {
                    $this->nota_file->store('public/nota_file');
                    $notaName = $this->nota_file->hashName();
                    $data['nota_file'] = $notaName;
            }

            foreach ($orders as $key => $value) {
                
                $stok = Penerimaan::find($value->penerimaan_id)->barang_sisa;
                
                $stokUpdate = $stok - $value->barang_qty;
                Penerimaan::find($value->penerimaan_id)->update(['barang_sisa' => $stokUpdate]);
                    
                    $data['penerimaan_id'] = $value->penerimaan_id;
                    $data['qty'] = $value->barang_qty;
                    $data['sisa'] = $stokUpdate;

                    if ($this->isUpdate) {

                        $penerimaan = Pengeluaran::find($value->id);
                        $data['sisa'] = $value->barang_sisa;
                        if ($penerimaan) {
                            $save = $penerimaan->update($data);
                            $msg = 'Data Berhasil Diubah';
                        }else{
                            $save = Pengeluaran::create($data);
                            $msg = 'Data Berhasil Ditambahkan';
                        }

                    }else{
                        $penerimaan = Penerimaan::find($value->penerimaan_id);
                        $save = Pengeluaran::create($data);
                        $save ? Order::destroy($value->id) : $this->isError("Data Gagal ditambahkan");

                        $dataReport = [
                            'date' => $this->date,
                            'penerimaan_id' => $value->penerimaan_id,
                            'pengeluaran_id' => $save->id,
                            'barang_id' => $penerimaan->barang_id,
                            'qty' => $value->barang_qty,
                            'sisa' => $stokUpdate,
                            'status' => 2,
                        ];
                        Report::create($dataReport);

                    }
                    $value->delete();
                
                    
            }
            
            $save ? $this->isSuccess("Success") : $this->isError("Failed");
            session()->flash('message', 'Data Berhasil Ditambahkan');
            return redirect()->to('/pengeluaran');
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
