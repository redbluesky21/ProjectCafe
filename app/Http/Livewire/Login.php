<?php

namespace App\Http\Livewire;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $email, $password, $remember;
    protected $rules = [
        'email' => 'required|email',
        'password' => 'required',
    ];
    public function render()
    {
        return view('livewire.login');
    }
    public function store()
    {
        $this->validate([
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('user')->attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            return redirect(route('resto.home'));
            $this->email = '';
            $this->password = '';
            $this->remember = '';
        } else {
            session()->flash('error', 'Periksa kembali username dan password anda');
        }
    }
}
