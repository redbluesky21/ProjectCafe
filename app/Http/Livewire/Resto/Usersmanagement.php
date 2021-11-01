<?php

namespace App\Http\Livewire\Resto;

use Livewire\WithFileUploads;

use App\Models\User as ModelsUsers;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SubKategori;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class Usersmanagement extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $Users_id, $name, $email, $password, $password_confirmation, $paginate = 10, $search, $roles_name, $users;

    protected $listeners = ['pagination' => 'selectPagination', 'deleteAllusersmanagement', 'fileChoosenHandler'];
    public function mount()
    {
        if (Gate::denies('admin-users')) {
            abort(404);
        }
    }
    public function selectPagination($paginateVal)
    {
        $this->paginate = $paginateVal;
    }
    public function render()
    {
        $result = ModelsUsers::select('users.name', 'users.email', 'users.id')
            ->where('users.name', 'like', '%' . $this->search . '%')
            ->orWhere('users.email', 'like', '%' . $this->search . '%')
            ->orderBy('users.name', 'asc')
            ->paginate($this->paginate);
        return view('livewire.resto.usersmanagement.main', [
            'result' => $result,
            'rows' => $result->count(),
            'roles' => Role::all(),
        ]);
    }
    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->roles_name = '';
        $this->Users_id = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function store()
    {
        $validation = $this->validate([
            'name'              =>    'required',
            'email'             =>    'required|email',
            'roles_name'        =>    'required',
            'password'          =>    'required|confirmed',
        ]);

        $users = ModelsUsers::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);
        $users->roles()->attach($this->roles_name);

        session()->flash('message', 'Data Created Successfully.');
        $this->resetInputFields();
        $this->emit('usersmanagementStore');
    }

    public function edit($id)
    {
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
        $this->emit('usersmanagementStore');
    }

    public function delete($id)
    {
        $data = ModelsUsers::find($id);
        $data->roles()->detach();
        $data->delete();
        session()->flash('message', 'Data Deleted Successfully.');
    }

    public function deleteAllusersmanagement($id)
    {
        foreach ($id as $v) {
            $data = ModelsUsers::find($v);
            $data->roles()->detach();
        }
        $data = ModelsUsers::whereIn('id', $id);
        $data->delete();
        session()->flash('message', 'Data ' . count($id) . ' Deleted Successfully.');
    }
    public function fileChoosenHandler($result)
    {
        $this->roles_name = $result;
    }
}
