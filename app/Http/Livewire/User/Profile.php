<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Livewire\Component;
use Livewire\WithFileUploads;
use League\Flysystem\File;

class Profile extends Component
{
    use WithFileUploads;
    
    public $name, $email, $password, $photo, $level, $oldPhoto;

    protected $rules = [    
        'name' => 'required|string|max:255',
        'password' => 'nullable|min:8',
        'photo' => 'image|mimes:jpg,jpeg,png|max:2048',

    ];
    protected $messages = [
        'email.required' => 'this field is required.',
        
        
    ];

    protected $listeners =[
        'delete',
        'cancelled'
    ];
    public function mount()
    {
        $user = User::find(Auth::user()->id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->level = $user->level;
        $this->oldPhoto = $user->photo;
    }
    public function render()
    {
        $user = User::find(Auth::user()->id);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->level = $user->level;
        $this->oldPhoto = $user->photo;

        return view('livewire.user.profile');
    }

    public function update()
    {  
        

        $data = $this->validate();

        if($this->password){
            $data['password'] = Hash::make($this->password);
        }

        if (!empty($this->photo)){
            $this->photo->store('public/photo');
            $imageName = $this->photo->hashName();
            $data['photo'] = $imageName;

            $this->handleImageIntervention($imageName);

            $image_path = "public/photo/".$this->oldPhoto;  // Value is not URL but directory file path
            if(Storage::exists($image_path)){
                Storage::delete($image_path);
                Storage::delete("public/photos_thumb/".$this->oldPhoto);
            }else{
                // dd('File does not exists.');
            }

        }

        $save = User::find(Auth::user()->id)->update($data);
        $save ? $this->isSuccess("Data Berhasil diUbah") : $this->isError("Data Gagal diUbah");

    }

    public function handleImageIntervention($imageName)
    {
        $manager = new ImageManager();
        $image = $manager->make('storage/photo/'.$imageName)->resize(100,100);
        $image->save('storage/photos_thumb/'.$imageName);
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
}
