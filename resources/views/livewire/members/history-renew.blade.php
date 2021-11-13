<div>

    <div>

        <x-card title=" Riwayat Perpanjangan Member">

            <table>
                <thead>

                    <th>Invoice</th>
                    <th>Kasir</th>
                    <th>Biaya</th>
                    <th>Tanggal Start</th>
                    <th>Tanggal Berakhir</th>

                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>


                            <td data-label="Invoice">
                                <a href="{{route('transaction.info',$item->transaction->id )}}" class="text-green-500 underline">
                                    {{$item->transaction->invoice}}</a>
                            </td>
                            <td data-label="Kasir">
                                {{$item->transaction->user->name}}
                            </td>
                            <td data-label="Total">
                                @rupiah($item->amount)
                            </td>
                            <td data-label="Total">
                               {{$item->renew_start->format('d F Y H:i')}}
                            </td>
                            <td data-label="Total">
                                {{$item->renew_end->format('d F Y H:i')}}
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
