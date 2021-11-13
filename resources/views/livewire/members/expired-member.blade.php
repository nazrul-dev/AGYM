<div>

    <div>
        <div class="mb-2">
            <x-button icon="users" onclick="location.href='{{route('members.data')}}'" positive label="Semua Member" />
        </div>
        <x-card title="Semua Member">

            <x-slot name="action">
                <x-input icon="search" wire:model="searchTerm" type="Search" placeholder="Cari Member" />
            </x-slot>
            <table>
                <thead>

                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telpon</th>
                    <th>Tanggal Expired</th>

                    <th class="text-right">Actions</th>
                </thead>
                <tbody>
                    @foreach ($members as $item)
                        <tr>

                            <td data-label="Nama lengkap">
                                {{ $item->name }}
                            </td>
                            <td data-label="Email ">
                                {{ $item->email ?? '' }}
                            </td>
                            <td data-label="Email ">
                                {{ $item->phone ?? '' }}
                            </td>
                            <td data-label="Tanggal Expired ">
                                {{ $item->subscription ? $item->subscription->expired_at->format('d M Y H:i') : '' }}
                            </td>

                            <td class="flex justify-end">
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <x-button flat icon="menu-alt-3" />
                                    </x-slot>

                                    <x-dropdown.item wire:click="info('{{ $item->id }}')" icon="eye"
                                        label="Info Detail" />
                                    <x-dropdown.item icon="view-boards" label="Riwayat Perpanjangan" />
                                    <x-dropdown.item wire:click="triggerConfirm('delete', '{{ $item->id }}')"
                                        icon="trash" label="Hapus" />
                                </x-dropdown>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-5">
                {{$members->links()}}
            </div>
        </x-card>
    </div>
    @if ($member)
    <x-modal.card title="info Detail {{ $member->name }}" max-width="lg" blur wire:model.defer="minfo">

            <div class="grid grid-cols-1">
                <div class="font-semibold"> <span class="font-normal">Nama Lengkap</span> : {{ $member->name }} </div>
                <div class="font-semibold"> <span class="font-normal">Type Identitas</span> : {{ $member->type }} </div>
                <div class="font-semibold"> <span class="font-normal">Nomor Identitas</span> : {{ $member->identity }} </div>
                <div class="font-semibold"> <span class="font-normal">Nama Telepon</span> : {{ $member->phone }} </div>
                <div class="font-semibold"> <span class="font-normal">Nama Email</span> : {{ $member->email}} </div>
                <div class="font-semibold"> <span class="font-normal">Tanggal Bergabung</span> : {{ $member->created_at->format('d F Y H:i') }} </div>
                <div class="font-semibold"> <span class="font-normal">Tanggal Expired</span> : {{ $member->subscription ? $member->subscription->expired_at->format('d F Y H:i') : '' }} </div>
                <div class="font-semibold"> <span class="font-normal">Alamat</span> : {{ $member->name }} </div>
            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-2">
                    <x-button outline negative label="Cancel" x-on:click="close" />

                </div>
            </x-slot>

        </x-modal.card>
        @endif
</div>
