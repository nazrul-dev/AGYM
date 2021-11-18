<div>
    <div class="flex flex-col items-center">
        <div class="w-full mx-auto md:w-2/3">

            @if (!$formcheckout)
                <x-card>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                        <div class="md:col-span-2">
                            <x-select label="Pilih Member" placeholder="Pilih Member" wire:model="memberSelected">
                                @foreach ($members as $member)
                                    <x-select.option label="{{ $member->name }}" value="{{ $member->id }}" />
                                @endforeach
                            </x-select>
                        </div>

                    </div>

                    @if (isset($memberSelected))
                        @if ($memberHasSelected->subscription)
                            <div class="p-3 my-5 border rounded-xl">
                                Status Member :
                                {{ check_member_active($memberHasSelected->subscription->expired_at) }}
                                <br>
                                Expired Member : {{ $memberHasSelected->subscription->expired_at }} <br>

                            </div>
                        @endif

                    @endif
                    <div class="flex justify-end gap-3 mt-5">

                        <x-button label="Perpanjangan Member" spinner="renew" wire:click="renew" positive />
                    </div>
                </x-card>
            @else
                <x-card>
                    <div class="p-5 mb-5 bg-gray-200 border rounded">
                        <h6>Biaya Perpanjangan</h6>
                        <h1 class="text-xl font-bold md:text-2xl">@rupiah($biayaRenew)</h1>
                    </div>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <x-input label="Dibayar" wire:model="dibayar" />
                        <x-input label="Discount" wire:model="discount" />
                        <div class="col-span-2">
                            <x-input label="Kembalian" readonly wire:model="kembalian" />
                        </div>
                        @if ($dibayar > $biayaRenew || $kembalian > 0)
                            <div class="my-2">
                                <x-toggle label="Simpan Sisa Kembalian" wire:model="simpansisa" />
                            </div>
                        @endif
                        <div class="md:col-span-2">
                            <x-textarea label="Catatan" wire:model.defer="notice" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-5">
                        <x-button label="Kembali" wire:click="clear" outline secondary />
                        <x-button label="Submit" spinner="submit" wire:click="submit" positive />
                    </div>
                </x-card>
            @endif


        </div>
    </div>
</div>
