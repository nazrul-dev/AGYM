<div>
    <div>
        <x-card title="Uang Tersimpan">
            <x-slot name="action">
                <x-input icon="search" type="Search" wire:model="searchTerm" placeholder="Cari Nama" />
            </x-slot>
            <table>
                <thead>

                    <th>Nama Lengkap</th>
                    <th>Sisa Simpanan</th>
                    <th>Tanggal Terkahir Diambil</th>
                    <th>Tanggal Terbuat</th>
                    <th class="text-right">Actions</th>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>


                            <td data-label="Nama">
                                {{ $item->f_name . ' ' . $item->l_name }}
                            </td>


                            <td data-label="Sisa Simpanan">
                                @rupiah($item->amount)
                            </td>
                            <td data-label="Tanggal Terkahir Diambil">
                                {{ $item->updated_at->format('d F Y H:i') }}
                            </td>
                            <td data-label="Tanggal Terbuat">
                                {{ $item->created_at->format('d F Y H:i') }}
                            </td>


                            <td data-label="Action" class="action-cell md:flex md:justify-end">
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <x-button flat icon="menu-alt-3" />
                                    </x-slot>

                                    <x-dropdown.item wire:click="pay('{{ $item->amount }}', '{{ $item->id }}')"
                                        icon="currency-dollar" label="Kembalikan " />
                                    <x-dropdown.item label="Hapus "
                                        wire:click="triggerConfirm('delete', '{{ $item->id }}')" icon="trash"
                                        negative xs />
                                </x-dropdown>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </x-card>
        <x-modal.card title="Kembalikan" blur wire:model.defer="mpay">

            <div class="p-5 mb-5 bg-gray-200 border rounded">
                <h6>Sisa Uang Tersimpan</h6>
                <h1 class="text-xl font-bold md:text-2xl">@rupiah($total)</h1>
            </div>
            <div class="my-2">
                <x-toggle label="Bayar Smua" wire:model="semua" />
            </div>

            @if (!$semua)
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                    <x-input type="number" label="Dibayar" placeholder="0" wire:model="amount" />
                    <x-input type="number" label="Sisa Simpanan" placeholder="0" wire:model.defer="change"
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
