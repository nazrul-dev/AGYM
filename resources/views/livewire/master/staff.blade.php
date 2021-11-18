<div>
    <div class="mb-5">
        <x-button icon="plus" wire:click="form" spinner="form" positive label="Staff" />
    </div>
    <x-card title="Data Staff">
        <x-slot name="action">
            <x-input icon="search" type="search" wire:model="searchTerm" placeholder="Cari Produk / Barcode" />
        </x-slot>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $item)
                    <tr>
                        <td data-label="Nama">{{ $item->name }}</td>
                        <td data-label="Email">{{ $item->email }}</td>
                        <td data-label="Role" class="uppercase">
                            {{ $item->role }}
                        </td>
                        <td data-label="Tanggal">{{ $item->created_at->format('d M Y H:i') }}</td>
                        <td data-label="Actions">
                            <div class="gap-2 action-cell md:flex md:justify-end">
                                <x-button icon="pencil" spinner="edit" wire:click="form(false,{{ $item->id }})"
                                    warning xs />
                                <x-button icon="key" spinner="passwordReset"
                                    wire:click="passwordReset('{{ $item->id }}')" info xs />
                                <x-button wire:click="triggerConfirm('delete', '{{ $item->id }}')" icon="trash"
                                    negative xs />
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-card>
    <x-modal.card title="Password Reset" blur wire:model.defer="mPass">
        <h1 class="mb-2">Ini adalah Password Baru Anda </h1>
        <div class="p-5 bg-yellow-100 border border-dashed">
            <h1 class="text-2xl font-bold tracking-widest">{{ $newpass }}</h1>
        </div>
        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-button outline negative label="Cancel" x-on:click="close" />

            </div>
        </x-slot>
    </x-modal.card>
    <x-modal.card title="{{ $update ? 'Ubah ' : 'Tambah ' }} Staff" blur wire:model.defer="mform">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <x-input label="Nama Staff" wire:model.defer="name" placeholder="Nama Staff" />
            <x-input type="email" wire:model.defer="email" label="Email" />
            @if (!$update)
                <x-input type="password" wire:model.defer="password" label="Password" />

            @endif
            <x-select label="Pilih Role" placeholder="Pilih Role" :options="[
                ['name' => 'Operator',  'id' => 'operator'],
                ['name' => 'Kasir', 'id' => 'kasir'],

            ]" option-label="name" option-value="id" wire:model.defer="role" />



        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-2">
                <x-button outline negative label="Cancel" x-on:click="close" />
                <x-button positive label="{{ $update ? 'Ubah ' : 'Tambah ' }}" wire:click="save" spinner="save" />
            </div>
        </x-slot>
    </x-modal.card>
</div>
