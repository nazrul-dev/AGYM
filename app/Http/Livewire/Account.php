<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Template;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Account extends Template
{
    public $user, $newpass, $curpass, $email;
    public function mount()
    {
        $this->user = auth()->user();
        $this->email = $this->user->email;
    }
    public function render()
    {
        return view('livewire.account');
    }

    public function save()
    {

        if (isset($this->curpass) && isset($this->newpass)) {
            $this->validate([
                'email' => 'required|email|unique:users,email,' . auth()->id(),
                'newpass' => 'required|min:8',
                'curpass' => 'required|min:8'
            ]);
            if (Hash::check($this->curpass, auth()->user()->password)) {

                auth()->user()->update([
                    'email' => $this->email,
                    'password' => Hash::make($this->newpass),
                ]);
                Auth::logout();
                $this->notification()->notify([
                    'title'       => 'Berhasil',
                    'description' => 'Password Berhasil Diubah',
                    'icon'        => 'success'
                ]);
                return;
            } else {
                $this->reset('newpass');
                $this->notification()->notify([
                    'title'       => 'Error',
                    'description' => 'Password Yang Anda masukan Salah',
                    'icon'        => 'error'
                ]);
                return;
            }
        }

        if (!$this->curpass && !$this->newpass) {
            $this->validate([
                'email' => 'required|email|unique:users,email,' . auth()->id(),

            ]);
            auth()->user()->update([
                'email' => $this->email,
            ]);
            return $this->notification()->notify([
                'title'       => 'Berhasil',
                'description' => 'Email Berhasil Berubah',
                'icon'        => 'success'
            ]);
        }
    }
}
