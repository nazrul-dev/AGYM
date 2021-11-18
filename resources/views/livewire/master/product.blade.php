<div>
    <div class="mb-5">
        <x-button icon="plus" wire:click="form" spinner="form" positive label="Produk" />
    </div>
    <x-card title="Semua Produk">
        <x-slot name="action">
            <x-input icon="search" type="Search" wire:model="searchTerm" placeholder="Cari Produk / Barcode" />
        </x-slot>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Harga Jual</th>
                    <th>Total Stok</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                    <tr>
                        <td data-label="Produk">{{ $item->name }}</td>
                        <td data-label="Kategori"> {{ $item->category->name }}</td>
                        <td data-label="Harga Jual">@rupiah($item->price)</td>
                        <td data-label="Total Stok">
                            <x-button xs positive label="{{ $item->stock->totalstock . ' PCS' }}"
                                wire:click="viewStockTrigger({{ $item->stock }})" />
                        </td>

                        <td data-label="Action" class="action-cell md:flex md:justify-end">
                            <x-dropdown>
                                <x-slot name="trigger">
                                    <x-button flat icon="menu-alt-3" />
                                </x-slot>

                                <x-dropdown.item icon="pencil" label="Edit Produk"
                                    wire:click="form(false,{{ $item->id }})" />

                                <x-dropdown.item wire:click="triggerConfirm('delete', '{{ $item->id }}')"
                                    icon="trash" label="Hapus" />
                            </x-dropdown>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>

    <x-modal.card title="Detail Stok" max-width="sm" blur wire:model.defer="mviewStock">
        @if ($mviewStock)
            <div>
                <ul>
                    <li class="py-2 border-t border-b">
                        <h6 class="text-sm">Stok Gudang</h6>
                        <h1 class="font-semibold">{{ $dviewStock['stock_warehouse'] }}</h1>
                    </li>
                    <li class="py-2 border-b">
                        <h6 class="text-sm">Stok Toko</h6>
                        <h1 class="font-semibold">{{ $dviewStock['stock_store'] }}</h1>
                    </li>

                    <li class="py-2 border-b">
                        <h6 class="text-sm">Stok Terjual</h6>
                        <h1 class="font-semibold">{{ $dviewStock['stock_sold'] }}</h1>
                    </li>
                    <li class="py-2 border-b">
                        <h6 class="text-sm">Stok Rusak</h6>
                        <h1 class="font-semibold">{{ $dviewStock['stock_damaged'] }}</h1>
                    </li>
                    <li class="py-2 border-b">
                        <h6 class="text-sm">Total Stok</h6>
                        <h1 class="font-semibold">{{ $dviewStock['stock_warehouse'] + $dviewStock['stock_store'] }}
                        </h1>
                    </li>
                </ul>
            </div>
        @endif

    </x-modal.card>

    <x-modal.card title="{{ $update ? 'Ubah ' : 'Tambah ' }} Produk" blur wire:model.defer="mform">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-input label="Nama Produk" wire:model.defer="product.name" placeholder="Nama Produk" />
            <x-input type="number" wire:model.defer="product.price" label="Harga Produk" />
            @if (!$update)
                <x-input type="number" wire:model.defer="stock_w" label="Stok Gudang" />
                <x-input type="number" wire:model.defer="stock_s" label="Stok Toko" />
            @endif

            <x-select label="Pilih Kategori" placeholder="Pilih Kategori" wire:model.defer="product.category_id">
                @foreach ($categories as $item)
                    <x-select.option label="{{ $item->name }}" value="{{ $item->id }}" />
                @endforeach

            </x-select>
            <x-input label="Barcode" wire:model.defer="product.barcode" />

            <div class="col-span-2">
                <x-input type="file" accept=".jpg,.png" class="p-2" id="image" label="Foto Produk"
                    wire:model="image" />
                <div wire:loading wire:target="image" class="mt-2 animate-pulse">Harap menunggu Sedang Mengupload
                    Foto....</div>
                @if ($update)
                    <br>
                    <label for="" class="text-red-500">Silahkan Masukan Foto Kembali Apabila Anda Ingin Mengubah Foto
                        Produk</label>
                @endif
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-button outline negative label="Cancel" x-on:click="close" />
                <x-button positive label="{{ $update ? 'Ubah ' : 'Tambah ' }}" wire:click="save" spinner="save" />
            </div>
        </x-slot>
    </x-modal.card>

    @push('scripts')
        <script>
            window.addEventListener('resetInput', event => {
                document.getElementById("image").value = "";
            })
        </script>
    @endpush
</div>
