<div>
    <div class="w-full mx-auto md:max-w-xl md:space-y-2">
        <x-card title="Pengaturan Akun">
            <div class="grid grid-cols-1 gap-3">
                <x-input type="Email" icon="mail" label="Email" wire:model.defer="email" />

            </div>
            <div class="py-2 mt-5 border-t">
                <div class="p-4 mb-2 border rounded-lg bg-green-50">
                    <x-label  label="Isi Field Ini Apabila Anda Ingin Menganti password " />
                </div>
                <div class="grid grid-cols-1 gap-3">
                    <x-input  type="Password" icon="key" wire:model.defer="curpass" label="Password Sekarang" />
                    <x-input type="Password" icon="key" wire:model.defer="newpass" label="Password Baru" />
                </div>
            </div>
            <div class="flex justify-end mt-10">
                <x-button label="Simpan Perubahan" spinner="save" wire:click="save" positive />
            </div>
        </x-card>

    </div>
</div>
