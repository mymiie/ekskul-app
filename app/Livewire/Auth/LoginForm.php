<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Livewire\Component;

class LoginForm extends Component
{
    public $identifier = '';
    public $password = '';
    public $loginType = 'siswa'; // siswa, guru, admin

    protected $rules = [
        'identifier' => 'required',
        'password' => 'required|min:6',
    ];

    public function login()
    {
        $this->validate();

        $user = null;

        switch ($this->loginType) {
            case 'siswa':
                $user = User::where('nis', $this->identifier)->first();
                break;
            case 'guru':
                $user = User::where('nip', $this->identifier)->first();
                break;
            case 'admin':
                $user = User::where('email', $this->identifier)->first();
                break;
        }

        if ($user && Hash::check($this->password, $user->password)) {
            Auth::login($user);
            
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'guru':
                    return redirect()->route('guru.dashboard');
                case 'user':
                default:
                    return redirect()->route('user.dashboard');
            }
        }

        session()->flash('error', 'Kredensial yang Anda masukkan tidak sesuai.');
    }

    public function render()
    {
        return view('livewire.auth.login-form');
    }
}