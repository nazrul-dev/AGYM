<div>
    <div class="flex flex-col items-center">
        <div class="w-full mx-auto md:w-2/3">
            <x-card title="Kas">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-select label="Pilih Tipe" placeholder="Pilih Tipes" :options="[
                        ['name' => 'Kas Masuk',  'id' => 'cashin'],
                        ['name' => 'Kas Keluar', 'id' => 'cashout'],

                    ]" option-label="name" option-value="id" wire:model.defer="field.type" />
                    <x-input label="Jumlah" type="number" wire:model.defer="field.amount" />
                    <div class="md:col-span-2">
                        <x-textarea label="Catatan" wire:model.defer="field.notice" />
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-5">
                    <x-button label="Reset" spinner="clear" wire:click="clear" outline negative />
                    <x-button label="Submit" spinner="submit" wire:click="submit" positive />
                </div>
            </x-card>
        </div>
    </div>
</div>
