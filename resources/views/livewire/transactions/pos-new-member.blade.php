<div>
    <div class="flex flex-col items-center">
        <div class="w-full mx-auto md:w-2/3">
            @if (!$formcheckout)
            <x-card title="Member Baru">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-input label="Nama Depan" wire:model.defer="member.first_name" />
                    <x-input label="Nama Belakang" wire:model.defer="member.last_name" />
                    <x-input label="Email" type="email" wire:model.defer="member.email" />
                    <x-input label="Telepon" type="number" wire:model.defer="member.phone" />
                    <div class="md:col-span-2">
                        <x-textarea label="Alamat" wire:model.defer="member.address" />
                    </div>
                    <x-select label="Jenis Identitas" :options="[
                            ['name' => 'Tidak Ada',  'id' => 'null'],
                            ['name' => 'KTP',  'id' => 'ktp'],
                            ['name' => 'SIM', 'id' => 'sim'],
                            ['name' => 'PASSPORT',   'id' => 'paspor'],
                    ]" option-label="name" option-value="id" wire:model.defer="member.type" />
                    <x-input label="Nomor Identitas" type="number" wire:model.defer="member.identity" />
                </div>
                <div class="flex justify-end gap-3 mt-5">
                    <x-button label="Reset" spinner="clear" wire:click="clear" outline negative/>
                    <x-button label="Checkout" spinner="checkout" wire:click="checkout" positive/>
                </div>
            </x-card>
            @else
            <x-card>
                <div class="p-5 mb-5 bg-gray-200 border rounded">
                    <h6>Biaya Pendaftaran</h6>
                    <h1 class="text-xl font-bold md:text-2xl">@rupiah($biayaPendaftaran)</h1>
                </div>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-input label="Dibayar" wire:model="dibayar"  />
                    <x-input label="Kembalian"  readonly wire:model="kembalian" />
                    <div class="md:col-span-2">
                        <x-textarea label="Catatan" wire:model.defer="notice" />
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-5" x-data="{formcheckout : @entangle('formcheckout')}">
                    <x-button label="Kembali" @click="formcheckout = false" outline secondary/>
                    <x-button label="Submit" spinner="submit" wire:click="submit" positive/>
                </div>
            </x-card>
            @endif

        </div>
    </div>
</div>
