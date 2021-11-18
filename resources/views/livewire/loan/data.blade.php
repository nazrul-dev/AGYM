<div>
    <div>
        <x-card title="Piutang">
            <x-slot name="action">
                <x-input icon="search" type="Search" wire:model="searchTerm" placeholder="Cari Invoice" />
            </x-slot>
            <table>
                <thead>

                    <th>Invoice</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>DP / Panjar</th>
                    <th>Sisa Piutang</th>
                    <th>Tanggal Jatuh Tempo</th>
                    <th class="text-right">Actions</th>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>

                            <td data-label="Invoice">
                                <a class="text-green-500 underline" href="{{ route('transaction.info', $item->id) }}">
                                    {{ $item->invoice }}</a>

                            </td>
                            <td data-label="Kasir">
                                {{ $item->user->name }}
                            </td>


                            <td data-label="Total Piutang">
                                @rupiah($item->total)
                            </td>
                            <td data-label="Panjar DP">
                                @rupiah($item->paid)
                            </td>
                            <td data-label="Sisa Piutang">
                                @rupiah($item->change)
                            </td>
                            <td data-label="Jatuh Tempo">
                                @if ($item->due_date)
                                    {{ $item->due_date->format('d M y H:i') }}
                                @endif
                            </td>

                            <td data-label="Action" class="action-cell md:flex md:justify-end">
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <x-button flat icon="menu-alt-3" />
                                    </x-slot>

                                    <x-dropdown.item icon="eye" href="{{ route('transaction.info', $item->id) }}"
                                        label="Info Detail" />
                                    <x-dropdown.item wire:click="pay('{{ $item->change }}', '{{ $item->id }}')"
                                        icon="currency-dollar" label="Bayar " />
                                </x-dropdown>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </x-card>
        <x-modal.card title="Bayar" blur wire:model.defer="mpay">

            <div class="p-5 mb-5 bg-gray-200 border rounded">
                <h6>Sisa Piutang</h6>
                <h1 class="text-xl font-bold md:text-2xl">@rupiah($sisa)</h1>
            </div>
            <div class="my-2">
                <x-toggle label="Lunaskan" wire:model="lunas" />
            </div>

            @if (!$lunas)
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <x-input type="number" label="Dibayar" placeholder="0" wire:model="dibayar" />
                    <x-input type="number" label="Sisa Piutang" placeholder="0" wire:model.defer="change"
                        aria-readonly="" readonly />
                </div>
            @endif
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button positive label="Proses" wire:click="submit" />
                </div>
            </x-slot>
        </x-modal.card>
    </div>
</div>
