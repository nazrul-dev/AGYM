<div>
    <div class="flex-col gap-3 md:flex md:flex-row">

        <div class="w-full py-5 md:w-1/3 md:py-0">
            <x-card title="Tambah Kategori">
                <x-input label="Nama Kategori" wire:model.defer="name" placeholder="Susu"  />
                <div class="flex justify-end gap-3 mt-5">
                    @if ($update)
                    <x-button  label="Reset" spinner="clear" wire:click="clear" negative outline />
                    @endif
                    <x-button  label="{{$update ? 'Ubah' : 'Tambah'}}" spinner="save" wire:click="save" positive />
                </div>
            </x-card>

        </div>
        <div class="w-full md:w-2/3">
            <x-card title="Data Kategori">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $item)
                            <tr>
                                <td data-label="Nama">{{ $item->name }}</td>
                                <td data-label="Tanggal">{{ $item->created_at->format('d M Y H:i') }}</td>
                                <td data-label="Actions">
                                    <div class="gap-2 action-cell md:flex md:justify-end">
                                        <x-button icon="pencil" spinner="edit" wire:click="edit('{{$item->id}}')" warning xs />
                                        <x-button wire:click="triggerConfirm('delete', '{{$item->id}}')" icon="trash" negative xs />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-card>

        </div>
    </div>
</div>
