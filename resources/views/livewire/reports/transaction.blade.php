<div>
    <x-card>
        <div class="flex-col items-end gap-3 space-y-2 md:space-y-0 md:flex md:flex-row">
            <x-select wire:model.defer="ftype" label="Pilih Tipe Transaksi" placeholder="Select one status">
                <x-select.option label="Semua Transaksi" value="all" />
                <x-select.option label="Penjualan Produk" value="sale" />
                <x-select.option label="Kas Masuk" value="cashin" />
                <x-select.option label="Kas Keluar" value="cashout" />
                <x-select.option label="Sewa" value="rent" />
                <x-select.option label="Member Baru" value="new_member" />
                <x-select.option label="Perpanjang Member" value="renew_member" />
            </x-select>
            <x-datetime-picker wire:model.defer="fstart" label="Dari Tanggal" without-time display-format="YYYY-MM-DD"
                parse-format="YYYY-MM-DD" placeholder="Dari Tanggal" display-format="DD-MM-YYYY HH:mm" />
            <x-datetime-picker wire:model.defer="fend" label="Sampai Tanggal" without-time display-format="YYYY-MM-DD"
                parse-format="YYYY-MM-DD" placeholder="Sampai Tanggal" display-format="DD-MM-YYYY HH:mm" />
            <x-button wire:click="filter" label="Filter laporan" positive icon="filter" />
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
        <div class="flex items-center p-3 space-x-5 rounded-lg shadow bg-info-100">
            <div>
                <x-icon name="shopping-cart" style="solid" class="w-12 h-12 text-info-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Jumlah Transaksi</h1>
                <h2 class="text-lg font-bold">{{ $totals->total }}</h2>
            </div>
        </div>
        <div class="flex items-center p-3 space-x-5 bg-green-100 rounded-lg shadow">
            <div>
                <x-icon name="chevron-double-up" style="solid" class="w-12 h-12 text-green-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Total Pendapatan</h1>
                <h2 class="text-lg font-bold">@rupiah($totals->pendapatan)</h2>
            </div>
        </div>
        <div class="flex items-center p-3 space-x-5 bg-red-100 border rounded-lg shadow">
            <div>
                <x-icon name="chevron-double-down" style="solid" class="w-12 h-12 text-red-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Total Pengeluaran</h1>
                <h2 class="text-lg font-bold">@rupiah($totals->pengeluaran)</h2>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <x-card title="Laporan">

            <x-slot name="action">
                <x-input icon="search" type="Search" placeholder="Cari Invoice" />
            </x-slot>
            <div class="h-56 overflow-y-auto" style="height: 60vh">
                <table>
                    <thead class="pb-2 border-b">
                        <th></th>
                        <th>Invoice</th>
                        <th>Kasir</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>

                    </thead>
                    <tbody>
                        @foreach ($data as $item)

                            <tr>
                                <td>
                                    @if ($item->type == 'cashout')
                                        <x-icon name="chevron-double-down" class="w-5 h-5 text-red-700" />
                                    @else
                                        <x-icon name="chevron-double-up" class="w-5 h-5 text-green-700" />
                                    @endif

                                </td>
                                <td data-label="Invoice">
                                    <a href="{{ route('transaction.info', $item->id) }}"
                                        class="text-green-500 underline">{{ $item->invoice }}</a>
                                </td>
                                <td data-label="Kasir">
                                    {{ $item->user->name }}
                                </td>
                                <td data-label="Type">
                                    {{ type_trans($item->type) }}
                                </td>

                                <td data-label="Total">
                                    @rupiah($item->total)
                                </td>
                                <td data-label="Status Bayar">
                                    <span
                                        class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none  {{ $item->paid_status == 'paylater' ? 'text-gray-100 bg-gray-600 ' : 'text-green-100 bg-green-600' }} capitalize rounded-full">
                                        {{ $item->paid_status }}</span>

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
