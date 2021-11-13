<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'name' => 'biaya_pendaftaran_member',
            'value' => 10000,
        ]);

        Setting::create([
            'name' => 'biaya_perpanjang_member',
            'value' => 10000,
        ]);

        Setting::create([
            'name' => 'biaya_sewa_gym',
            'value' => 10000,
        ]);

        Setting::create([
            'name' => 'nama_gym',
            'value' => 'GYM',
        ]);


        Setting::create([
            'name' => 'alamat_gym',
            'value' => 10000,
        ]);
        Setting::create([
            'name' => 'telepon_gym',
            'value' => 10000,
        ]);
        Setting::create([
            'name' => 'email_gym',
            'value' => 10000,
        ]);
        Setting::create([
            'name' => 'telegram_chat_id',
            'value' => 10000,
        ]);
        Setting::create([
            'name' => 'telegram_bot',
            'value' => 10000,
        ]);

    }
}
