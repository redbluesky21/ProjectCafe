<?php

namespace App\Http\Livewire\Resto;

use App\Models\User as ModelsUsers;
use Livewire\Component;
use App\Models\SubKategori;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class User extends Component
{
    public $Users_id, $name, $email, $password, $password_confirmation, $roles_name, $users;

    protected $listeners = ['fileChoosenHandler'];

    public function mount()
    {
        $this->Users_id = Auth::id();
    }
    public function render()
    {
        $result = ModelsUsers::findOrFail($this->Users_id);
        return view('livewire.resto.user.main', [
            'row' => $result,
            'roles' => Role::all(),
        ]);
    }
    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->roles_name = '';
        $this->password = '';
    }


    public function edit()
    {
        $id = $this->Users_id;
        $data = ModelsUsers::findOrFail($id);
        $this->Users_id = $id;
        $this->name = $data->name;
        $this->email = $data->email;
        $this->users = $data;
    }

    public function update()
    {
        if ($this->roles_name != null && $this->password != null) {
            $validation = $this->validate([
                'name'              =>    'required',
                'email'             =>    'required|email',
                'roles_name'        =>    'required',
                'password'          =>    'required|confirmed',
            ]);
            $data = ModelsUsers::find($this->Users_id);
            $data->roles()->sync($this->roles_name);
            $data->update([
                'name'              =>   $this->name,
                'email'             =>   $this->email,
                'password'          =>   Hash::make($this->password),
            ]);
        } else if ($this->roles_name != null && $this->password == null) {
            $validation = $this->validate([
                'name'              =>    'required',
                'email'             =>    'required|email',
                'roles_name'        =>    'required',
            ]);
            $data = ModelsUsers::find($this->Users_id);
            $data->roles()->sync($this->roles_name);
            $data->update([
                'name'              =>   $this->name,
                'email'             =>   $this->email,
            ]);
        } else if ($this->roles_name == null && $this->password != null) {
            $validation = $this->validate([
                'name'              =>    'required',
                'email'             =>    'required|email',
                'password'          =>    'required|confirmed',
            ]);
            $data = ModelsUsers::find($this->Users_id);
            $data->update([
                'name'              =>   $this->name,
                'email'             =>   $this->email,
                'password'          =>   Hash::make($this->password),
            ]);
        } else {
            $validation = $this->validate([
                'name'              =>    'required',
                'email'             =>    'required|email',
            ]);
            $data = ModelsUsers::find($this->Users_id);
            $data->update([
                'name'              =>   $this->name,
                'email'             =>   $this->email,
            ]);
        }
        session()->flash('message', 'Data Updated Successfully.');
        $this->resetInputFields();
        $this->emit('userStore');
    }

    public function fileChoosenHandler($result)
    {
        $this->roles_name = $result;
    }
}
