<?php

namespace App\Http\Livewire\Master;

use App\Http\Livewire\Template;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Staff extends Template
{
    public $update = false,$mform = false,$mPass = false, $newpass;
    public $name,$email,$password,$role = 'kasir',$ids,$cpassword = '';
    public function mount(){
        if (!in_array(auth()->user()->role,['master', 'operator'])) {
            return abort(403, 'Tidak Memiliki Akses');
        }
    }

    public function render()
    {
        $users = User::where('role', '!=', 'master')->where(function ($q) {
            $q->where('name', 'like', '%' . $this->searchTerm . '%');

        })->latest()->paginate(100);
        return view('livewire.master.staff', compact('users'));
    }

    public function passwordReset(User $user){
        $this->newpass = \Str::upper(codeRandom(8));
        $user->update([
            'password' =>  Hash::make($this->newpass)
        ]);
        $this->mPass = true;

    }

    public function form($value = true, $id = null)
    {

        $this->reset(['mform', 'update', 'name', 'email', 'password', 'cpassword', 'ids', 'role']);

        if ($value) {
            $this->update = false;
        } else {
            $r = User::find($id);

            if ($r) {
                $this->update = true;
                $this->ids = $r->id;
                $this->name = $r->name;
                $this->email = $r->email;
                $this->role = $r->role;
                $this->cpasword = null;
            };
        }
        $this->mform = true;
    }
    public function delete(User $user)
    {

        $user->delete();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Staff Berhasil Dihapus',
            'icon'        => 'success'
        ]);
    }
    public function save()
    {

        $this->validate([
            'email' => 'required|email|unique:users,email,'.$this->ids,
            'name' => 'required|string',
            'password' => 'required|min:8',
            'role' => 'required|in:master,operator,kasir',
        ]);
        User::updateOrCreate(
            ['id' => $this->ids],
            [
                'email' => $this->email,
                'name' => $this->name,
                'password' => $this->update ? $this->cpassword : Hash::make($this->password),
                'role' => $this->role,
            ]
        );

        $this->mform = false;
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Staff Berhasil Ditambahkan',
            'icon'        => 'success'
        ]);
    }

}
