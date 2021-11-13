<?php

namespace App\Http\Livewire;

use App\Models\Setting as ModelsSetting;
use App\Http\Livewire\Template;

class Setting extends Template
{
    public $type = 'umum';
    public $biaya = [
        'pendaftaran_member' => 0 ,
        'perpanjang_member' => 0 ,
        'sewa_gym' => 0
    ];
    public $umum = [
        'nama_gym' => 'GYM Contoh' ,
        'alamat_gym' => 'Jl.Contoh Komplex ' ,
        'telepon_gym' => '0822587455',
        'email_gym' => 'contoh@contoh.com',
        'telegram_chat_id' => 0,
        'telegram_bot' => 0,
    ];
    public function mount($type)
    {
        if (auth()->user()->role != 'master') {
            return abort(403, 'Tidak Memiliki Akses');
        }
        $this->type = $type;
        $this->biaya['pendaftaran_member'] = $this->getValue('biaya_pendaftaran_member');
        $this->biaya['perpanjang_member'] = $this->getValue('biaya_perpanjang_member');
        $this->biaya['sewa_gym'] = $this->getValue('biaya_sewa_gym');

        $this->umum['nama_gym'] = $this->getValue('nama_gym');
        $this->umum['alamat_gym'] = $this->getValue('alamat_gym');
        $this->umum['telepon_gym'] = $this->getValue('telepon_gym');
        $this->umum['email_gym'] = $this->getValue('email_gym');
        $this->umum['telegram_chat_id'] = $this->getValue('telegram_chat_id');
        $this->umum['telegram_bot'] = $this->getValue('telegram_bot');
    }
    public function render()
    {
        return view('livewire.setting');
    }

    public function saveumum()
    {
        $this->getValue('nama_gym', true, $this->umum['nama_gym']);
        $this->getValue('alamat_gym', true, $this->umum['alamat_gym']);
        $this->getValue('telepon_gym', true, $this->umum['telepon_gym']);
        $this->getValue('email_gym', true, $this->umum['email_gym']);
        $this->getValue('telegram_chat_id', true, $this->umum['telegram_chat_id']);
        $this->getValue('telegram_bot', true, $this->umum['telegram_bot']);
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Melakukan Perubahan Pnegaturan Umum',
            'icon'        => 'success'
        ]);
    }

    public function savebiaya()
    {

        $this->getValue('biaya_pendaftaran_member', true, $this->biaya['pendaftaran_member']);
        $this->getValue('biaya_perpanjang_member', true, $this->biaya['perpanjang_member']);
        $this->getValue('biaya_sewa_gym', true, $this->biaya['sewa_gym']);
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Melakukan Perubahan Pnegaturan Biaya',
            'icon'        => 'success'
        ]);
    }

    public function getValue($name, $update = false, $value = '')
    {
        $q = ModelsSetting::where('name', $name)->first();
        if ($update && $value) {
            $q->update(['value' => $value]);
        }
        return $q->value;
    }
}
