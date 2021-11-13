<div>
    <div>

    </div>
    <div>
        <div class="mb-2">
            <x-button icon="plus" onclick="location.href='{{route('transaction.select.type')}}'" positive label="Transaksi" />
        </div>
        <x-card >
            <x-slot name="title">
              <a href="{{route('reports.transactions')}}">
                <x-button  positive label="Laporan" />
            </a>
            </x-slot>
            <x-slot name="action">
                <x-input icon="search" type="Search" wire:model="searchTerm" placeholder="Cari Invoice" />
            </x-slot>
            <table>
                <thead>

                    <th>Invoice</th>
                    <th>Kasir</th>
                    <th>Type</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th class="text-right">Actions</th>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>

                            <td data-label="Invoice">
                                {{ $item->invoice }}
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
                                <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none  {{$item->paid_status == 'paylater' ? 'text-gray-100 bg-gray-600 ' : 'text-green-100 bg-green-600' }} capitalize rounded-full"> {{ $item->paid_status }}</span>

                            </td>
                            <td data-label="Tanggal">
                                {{ $item->created_at->format('d M y H:i') }}
                            </td>

                            <td data-label="Action" class="action-cell md:flex md:justify-end">
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <x-button flat icon="menu-alt-3"   />
                                    </x-slot>

                                    <x-dropdown.item icon="eye" href="{{route('transaction.info', $item->id)}}" label="Info Detail" />
                                    <x-dropdown.item wire:click="triggerConfirm('delete', '{{$item->id}}')" icon="trash" label="Hapus" />
                                </x-dropdown>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-5">
                {{$data->links()}}
            </div>
        </x-card>
    </div>
</div>
