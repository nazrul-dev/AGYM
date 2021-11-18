<div>
    <x-card>
        <div class="flex-col items-end gap-3 space-y-2 md:space-y-0 md:flex md:flex-row">
            <x-select wire:model.defer="ftype" label="Pilih Tipe Stok" placeholder="Select one status">
                <x-select.option label="Semua Stok" value="all" />
                <x-select.option label="Stok Toko" value="store" />
                <x-select.option label="Stok Gudang" value="warehouse" />

            </x-select>
            <x-select wire:model.defer="fprod" label="Pilih Produk" placeholder="Select one status">
                <x-select.option label="Semua Produk" value="all" />
                @foreach ($products as $item)
                    <x-select.option label="{{ $item->name }}" value="{{ $item->id }}" />

                @endforeach

            </x-select>
            <x-datetime-picker wire:model.defer="fstart" label="Dari Tanggal" without-time display-format="YYYY-MM-DD"
                parse-format="YYYY-MM-DD" placeholder="Dari Tanggal" display-format="DD-MM-YYYY HH:mm" />
            <x-datetime-picker wire:model.defer="fend" label="Sampai Tanggal" without-time display-format="YYYY-MM-DD"
                parse-format="YYYY-MM-DD" placeholder="Sampai Tanggal" display-format="DD-MM-YYYY HH:mm" />
            <x-button wire:click="filter" label="Filter " positive icon="filter" />
        </div>
    </x-card>
    <style>
        thead th {
            position: sticky;
            top: 0;
            background: white;
            z-index: 5
        }

        tfoot {
            position: sticky;
            bottom: 0;
            background: white;
            z-index: 5
        }

    </style>
    <div class="grid grid-cols-1 gap-2 my-5 md:grid-cols-3">
        <div class="flex items-center p-3 space-x-5 border rounded-lg shadow bg-info-100">
            <div>
                <x-icon name="cube" style="solid" class="w-12 h-12 text-info-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Total Data</h1>
                <h2 class="text-lg font-bold">{{ $totals->total . ' Pcs' }}</h2>
            </div>
        </div>
        <div class="flex items-center p-3 space-x-5 bg-red-100 rounded-lg shadow">
            <div>
                <x-icon name="chevron-double-down" style="solid" class="w-12 h-12 text-red-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Total Stok Keluar</h1>
                <h2 class="text-lg font-bold">{{ $totals->tdown . ' Pcs' }}</h2>
            </div>
        </div>
        <div class="flex items-center p-3 space-x-5 bg-green-100 rounded-lg shadow">
            <div>
                <x-icon name="chevron-double-up" style="solid" class="w-12 h-12 text-green-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Total Stok Masuk</h1>
                <h2 class="text-lg font-bold">{{ $totals->tup . ' Pcs' }}</h2>
            </div>
        </div>

    </div>
    <div class="mt-5">
        <x-card title="Laporan">


            <div class="h-56 overflow-y-auto" style="height: 60vh">
                <table>
                    <thead class="pb-2 border-b">
                        <th></th>
                        <th>Produk</th>
                        <th>Tipe Stok</th>
                        <th>Jumlah</th>
                        <th>Stok Terakhir</th>
                        <th>Keterangan</th>
                        <th>Tanggal</th>

                    </thead>
                    <tbody>
                        @foreach ($data as $item)

                            <tr>
                                <td>
                                    @if ($item->status == 'down')
                                        <x-icon name="chevron-double-down" class="w-5 h-5 text-red-700" />

                                    @endif
                                    @if ($item->status == 'up')
                                        <x-icon name="chevron-double-up" class="w-5 h-5 text-green-700" />


                                    @endif
                                    @if ($item->status == 're')
                                        <x-icon name="refresh" class="w-5 h-5 text-yellow-700" />
                                    @endif

                                </td>

                                <td data-label="Produk">
                                    {{ $item->product->name }}
                                </td>
                                <td data-label="Type">
                                    {{ $item->type == 'store' ? 'Toko' : 'Gudang' }}
                                </td>
                                <td data-label="jumlah">
                                    {{ $item->value . ' PCS' }}
                                </td>
                                <td data-label="Stok Terakhir">
                                    {{ $item->last_amount . ' PCS' }}
                                </td>
                                <td data-label="Keterangan" width="50">
                                    <p class="flex-wrap text-sm tracking-tighter">{{ $item->notice }}</p>
                                </td>

                                <td data-label="Tanggal">
                                    {{ $item->created_at->format('d M y H:i') }}
                                </td>


                            </tr>

                        @endforeach
                    </tbody>

                </table>

            </div>
        </x-card>
    </div>
</div>
