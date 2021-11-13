<div>
    <div class="w-full mx-auto md:max-w-lg">

        <x-card title="Pengaturan {{ ucFirst($type) }}">
            <div class="space-y-2">
            @if ($type == 'umum')
                <x-input label="nama GYM"  wire:model.defer="umum.nama_gym"/>
                <x-input label="Email" type="email"  wire:model.defer="umum.email_gym"/>
                <x-input label="Alamat" wire:model.defer="umum.alamat_gym" />
                <x-input label="Telepon"  type="number" wire:model.defer="umum.telepon_gym"/>
                <div class="pt-2 mt-2 space-y-2 border-t">
                    <h1 class="mb-2 font-semibold">Telegram Config</h1>
                    <x-input label="Chat ID "   wire:model.defer="umum.telegram_chat_id"/>
                    <x-input label="Botname "   wire:model.defer="umum.telegram_bot"/>
                </div>
            @else

                <x-input label="Biaya Rent Gym" wire:model.defer="biaya.pendaftaran_member" />
                <x-input label="Biaya Perpanjangan Member" wire:model.defer="biaya.perpanjang_member" />
                <x-input label="Biaya Pendaftaran Member Baru" wire:model.defer="biaya.sewa_gym" />
                @endif
            </div>

            <div class="mt-5">
                <div class="flex justify-end">
                    <x-button label="Simpan Perubahan" spinner="save{{$type}}" wire:click="save{{$type}}"  positive/>
                </div>
            </div>
        </x-card>
    </div>
</div>
