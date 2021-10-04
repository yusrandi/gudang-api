<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\WithFileUploads;

class Wireuser extends Component
{
    use WithFileUploads;
    public $level, $photo, $photo_update, $name, $email, $password, $selectedItemId;
    public $PATH = 'photo/';

    protected $rules = [
        'level' => 'required',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'photo' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
    ];
    protected $messages = [
        'email.required' => 'this field is required.',
        'email.email' => 'this field must a email.',
        'name.required' => 'this field is required.',
        
    ];

    protected $listeners =[
        'delete',
        'cancelled'
    ];

    public function selectemItem($itemId, $action)
    {

        $this->selectedItemId = $itemId;
        $action == 'delete' ? $this->triggerConfirm() : $this->edit(); 
        
    }
    public function edit()
    {
        $data = User::find($this->selectedItemId);
        $this->level = $data->level;
        $this->photo_update = $data->photo;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->password = null;
        
    }
    
    public function save()
    {
        $this->selectedItemId ? $this->update()  : $this->store();       
    }
    public function store()
    {
        $data = $this->validate();
        if (!empty($this->photo)){
            $this->photo->store('public/photo');
            $imageName = $this->photo->hashName();
            $data['photo'] = $imageName;

            $this->handleImageIntervention($imageName);

        }
        $data['password'] = Hash::make($this->password);
        $data['level'] = $this->level;

        $save = User::create($data);
        $save ? $this->isSuccess("Data Berhasil Tersimpan") : $this->isError("Data Gagal Tersimpan");

        $this->cleanVars();

    }
    public function update()
    {
        
        $validateData = [];
        
        $validateData = array_merge($validateData,[
            'level' => 'required',
            'name' => 'required',
        ]);
        $data = $this->validate($validateData);
       
        if (!empty($this->photo)){
            $validateData = array_merge($validateData,[
                'photo' => 'image|mimes:jpg,jpeg,png|max:2048',
            ]);
            $this->photo->store('public/photo');
            $imageName = $this->photo->hashName();
            $data['photo'] = $imageName;

            $this->handleImageIntervention($imageName);

        }
        if($this->password){
            $data['password'] = Hash::make($this->password);
        }

        $save = User::find($this->selectedItemId)->update($data);
        $save ? $this->isSuccess("Data Berhasil diUbah") : $this->isError("Data Gagal diUbah");

        $this->cleanVars();

    }
    public function delete()
    {
        
        $delete = User::destroy($this->selectedItemId);
        $delete ? $this->isSuccess("Data Berhasil Terhapus") : $this->isError("Data Gagal Dihapus");
        
        $this->cleanVars();

    }

    public function render()
    {
        return view('livewire.wireuser',[
            'users' => User::orderby('level', 'ASC')->get()
        ]);
    }

    public function handleImageIntervention($imageName)
    {
        $manager = new ImageManager();
        $image = $manager->make('storage/photo/'.$imageName)->resize(100,100);
        $image->save('storage/photos_thumb/'.$imageName);
    }
    public function cleanVars()
    {
        $this->selectedItemId = null;
        $this->level = null;
        $this->photo = null;
        $this->name = null;
        $this->email = null;
        $this->password = null;
    }

    public function triggerConfirm()
    {
        $this->confirm('yakin akan menghapus data ?', [
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
