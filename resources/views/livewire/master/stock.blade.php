<div>
    <div>
        <div class="mb-5">
            <a href="{{ route('stocks.data', $type == 'warehouse' ? 'store' : 'warehouse') }}">
                <x-button icon="refresh" positive label="Stok {{ $type == 'warehouse' ? 'Toko' : 'Gudang' }}" />
            </a>
        </div>
        <x-card title="Stok {{ changeLangStock($type) }}">
            <x-slot name="action">
                <x-input icon="search" wire:model="searchTerm" type="Search" placeholder="Cari Barcode / Produk" />
            </x-slot>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Barcode</th>
                        <th>Harga Jual</th>
                        <th>Total Stok</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td data-label="Produk">{{ $item->product->name }}</td>
                            <td data-label="Barcode">{{ $item->product->barcode }}</td>
                            <td data-label="Harga Jual">@rupiah($item->product->price)</td>
                            <td data-label="Total Stok">{{ $item->total.' PCS' }}</td>
                            <td data-label="Action"  class="md:flex md:justify-end action-cell">
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <x-button flat icon="menu-alt-3" />
                                    </x-slot>

                                    <x-dropdown.item icon="plus" label="Tambah Stok {{$lang}}" wire:click="form('add', {{$item->id}})" />
                                    <x-dropdown.item icon="trending-up" wire:click="form('export', {{$item->id}})"  label="Export Ke {{$type == 'store' ? 'Gudang' : 'Toko'}}" />
                                    <x-dropdown.item icon="pencil" wire:click="form('edit', {{$item->id}}, {{$item->total}})"  label="Edit Stok {{$lang}}" />
                                </x-dropdown>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </x-card>

        <x-modal.card title="{{ucFirst(formTypeLang($formType))}} Stok {{$lang}}" max-width="sm" blur wire:model.defer="mform">

            <div>
                <x-input wire:model.defer="value" label="Jumlah" />
            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-2">
                    <x-button outline negative label="Cancel" x-on:click="close" />
                    <x-button positive label="{{ucFirst(formTypeLang($formType))}}" wire:click="{{$formMethod}}" />
                </div>
            </x-slot>

        </x-modal.card>
    </div>
