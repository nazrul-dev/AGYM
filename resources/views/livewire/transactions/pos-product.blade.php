<div>
    <h1 class="pb-5 text-xl font-semibold text-gray-600">Transaksi Produk</h1>
    <div class="grid grid-cols-1 gap-3 md:grid-cols-3">
        <div>
            <x-card title="Ringkasan">
                <div class="pb-2">
                    <label class="font-semibold ">Total</label>
                    <h1 class="text-xl font-bold">@rupiah($cart['total'])</h1>
                </div>
                <div class="pt-2 pb-2 border-t">
                    <label class="font-semibold ">Jumlah Item</label>
                    <h1 class="text-xl font-bold">{{ $cart['tqty'] }} PCS</h1>
                </div>
                <div class="flex justify-between gap-2 pt-5 border-t">
                    <x-button label="Reset" wire:click="cartClear" negative />
                    <div class="flex gap-2">
                        <x-button label="keranjang" onClick="$openModal('mcart')" info />
                        <x-button label="Chekcout" wire:click="checkout" positive />
                    </div>
                </div>
            </x-card>
        </div>
        <div class="md:col-span-2">
            <div class="flex flex-col items-center gap-2 md:flex-row">
                <div class="flex-1">
                    <x-input right-icon="search" type="search" wire:model="searchTerm"
                        placeholder="Cari Nama Product / Barcode / Kategori" />
                </div>

            </div>
            <div class="mt-5 overflow-y-auto " style="height:70vh">
                <div class="grid grid-cols-2 gap-2 md:grid-cols-3">
                    @foreach ($products as $item)
                        <a href="javascript:void(0)" wire:click="prodSelected('{{ $item->id }}')"
                            class="overflow-hidden border rounded-lg shadow">
                            <img class="object-contain w-full pt-3 h-28 md:h-48" src="{{ $item->image }}" alt="">
                            <div class="p-3 border-t bg-gray-50">
                                <span class="text-sm">{{ $item->category->name }}</span>
                                <h1 class="text-sm font-semibold md:text-base">{{ $item->name }}</h1>
                                <h1 class="font-bold md:text-xl">@rupiah($item->price)</h1>
                            </div>
                        </a>
                    @endforeach



                </div>
            </div>

        </div>
    </div>
    <x-modal.card title="Checkout" blur wire:model.defer="mcheckout">

        <div class="p-5 mb-5 bg-gray-200 border rounded">
            <h6>Total</h6>
            <h1 class="text-xl font-bold md:text-2xl">@rupiah($cart['total'])</h1>
        </div>
        <div class="my-2">
            <x-toggle label="Pembayaran Tunai" wire:model="tunai" />
        </div>


        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            <x-input label="Nama Depan" wire:model.defer="pelanggan.first_name" />
                <x-input label="Nama Belakang" wire:model.defer="pelanggan.last_name" />
            @if ($tunai)
                <x-inputs.currency label="Dibayar" placeholder="0" wire:model="dibayar" />

                <x-inputs.currency label="Sisa Kembalian" placeholder="0" wire:model.defer="kembalian" aria-readonly="" readonly />
            @else
                <x-inputs.currency label="Panjar / DP" placeholder="0" wire:model="panjar" />
                <x-inputs.currency label="Sisa Piutang" placeholder="0" wire:model.defer="sisa" aria-readonly="" readonly />
                <div class="col-span-2">
                    <x-datetime-picker wire:model.defer="duedate" label="Peringatan Jatuh Tempo" without-time display-format="YYYY-MM-DD"
                    parse-format="YYYY-MM-DD" placeholder="Tanggal " display-format="DD-MM-YYYY HH:mm"
                     />
                </div>
            @endif
        </div>



        <div class="grid grid-cols-1 mt-4 ">

            <x-textarea label="Catatan" wire:model.defer="notice" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Cancel" x-on:click="close" />
                <x-button positive label="Proses" wire:click="submit" />
            </div>
        </x-slot>
    </x-modal.card>
    <x-modal.card title="Set Kuantiti" max-width="sm" blur wire:model.defer="mqty">
        <div class="grid grid-cols-1">
            <x-input label="kuantiti" wire:model.defer="qty" type="number" />
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">

                <x-button flat label="Cancel" x-on:click="close" />
                <x-button positive label="Tambahkan " wire:click="addCart" />
            </div>
        </x-slot>
    </x-modal.card>
    <x-modal.card title="Keranjang" blur wire:model.defer="mcart">
        <div class="overflow-y-scroll" style="height: 60vh">
            @foreach ($cart['contents'] as $cart)
                <div class="p-3 my-2 border rounded-xl">
                    <div class="flex items-center justify-between">

                        <div class="flex items-center">
                            <div class="flex flex-col pr-2 space-y-2 border-r ">
                                <x-button icon="chevron-up"
                                    wire:click="changeQty('{{ $cart['id'] }}','up', {{ $cart['quantity'] }})" sm
                                    positive />
                                <x-button icon="chevron-down"
                                    wire:click="changeQty('{{ $cart['id'] }}','down', {{ $cart['quantity'] }})" sm
                                    negative />
                            </div>
                            <div class="pl-2">
                                {{ $cart['name'] }}<br>
                                Harga <strong>{{ $cart['price'] }}</strong> <br> Quantity
                                <strong>{{ $cart['quantity'] . ' PCS' }}</strong>
                            </div>
                        </div>
                        <div>
                            <p>Subtotal</p>
                            <strong>
                                {{ Cart::get($cart['id'])->getPriceSum() }}
                            </strong>
                        </div>
                        <div>
                            <x-button icon="trash" wire:click="deleteCart('{{ $cart['id'] }}')" sm negative />

                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </x-modal.card>
</div>
