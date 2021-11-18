<div>
    <div class="w-full mx-auto md:max-w-xl md:space-y-2">
        <x-card title="Invoice #{{ $transaction->invoice }}">
            <div class="grid grid-cols-1">
                <div class="font-semibold"><span class="font-normal">Tipe Transaksi</span> :
                    {{ type_trans($transaction->type) }}</div>

                @if (!in_array($transaction->type, ['cashout', 'cashin']))
                    @if ($transaction->type == 'renew_member')
                        <div class="font-semibold"> <span class="font-normal">Nama Member</span> :
                            {{ $transaction->dec_customers['first_name'] . ' ' . $transaction->dec_customers['last_name'] }}
                        </div>
                    @else
                        <div class="font-semibold"> <span class="font-normal">Nama Pelanggan</span> :
                            {{ $transaction->dec_customers['first_name'] . ' ' . $transaction->dec_customers['last_name'] }}
                        </div>

                    @endif
                @endif

                @if (in_array($transaction->type, ['cashout', 'cashin']))

                    <div class="font-semibold"><span class="font-normal">Total</span> : @rupiah($transaction->total)
                    </div>
                    <div class="font-semibold"><span class="font-normal">Kasir</span> :
                        {{ $transaction->user->name ?? 0 }} </div>

                @else
                    <div class="font-semibold"><span class="font-normal">Subtotal</span> :
                        @rupiah($transaction->amount)
                    </div>
                    @if ($transaction->discount)
                        <div class="font-semibold"><span class="font-normal">Diskon</span> :
                            @rupiah($transaction->discount)
                        </div>
                    @endif

                    <div class="font-semibold"><span class="font-normal">Total</span> : @rupiah($transaction->total)
                    </div>
                    @if ($transaction->paid_status == 'paylater')
                        <div class="font-semibold"> <span class="font-normal">Panjar / DP</span> :
                            @rupiah($transaction->paid)
                        </div>
                        <div class="font-semibold"><span class="font-normal">Sisa Piutang</span> :
                            @rupiah($transaction->change) </div>
                        @if ($transaction->due_date)
                            <div class="font-semibold"><span class="font-normal">Peringatan Jatuh Tempo</span> :
                                {{ $transaction->due_date->format('d F Y H:i') }} </div>
                        @endif

                    @else
                        <div class="font-semibold"> <span class="font-normal">Dibayar</span> :
                            @rupiah($transaction->paid)
                        </div>
                        <div class="font-semibold"><span class="font-normal">Uang Kembalian</span> :
                            @rupiah(($transaction->paid - $transaction->amount) + $transaction->discount) </div>
                    @endif

                    <div class="font-semibold"><span class="font-normal">Kasir</span> :
                        {{ $transaction->user->name }} </div>
                    <div class="font-semibold"><span class="font-normal">Status Pembayaran</span> :
                        <span
                            class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none  {{ $transaction->paid_status == 'paylater' ? 'text-gray-100 bg-gray-600 ' : 'text-green-100 bg-green-600' }} capitalize rounded-full">
                            {{ $transaction->paid_status }}</span>
                    </div>
                @endif

                <div class="font-semibold"><span class="font-normal">Tanggal Transaksi</span> :
                    {{ $transaction->created_at->format('d F Y H:i') }} </div>
            </div>
            <div class="p-3 mt-5 border rounded-lg">
                <x-label>Keterangan / Catatan</x-label>
                {{ $transaction->notice }}
            </div>
        </x-card>
        @if ($transaction->type == 'sale')
            <x-card title="Item Order">
                @foreach ($transaction->dec_orders as $item)
                    <div class="p-3 my-2 border rounded-xl">
                        <div class="flex items-center justify-between">

                            <div class="flex items-center">

                                <div class="pl-2">
                                    Produk <strong>{{ $item['name'] }}</strong><br>
                                    Harga <strong>@rupiah($item['price'])</strong> <br> Quantity
                                    <strong>{{ $item['quantity'] . ' PCS' }}</strong>
                                </div>
                            </div>
                            <div>
                                <p>Subtotal</p>
                                <strong>
                                    @rupiah($item['price'] * $item['quantity'])
                                </strong>
                            </div>

                        </div>
                    </div>
                @endforeach
            </x-card>
        @endif
    </div>
</div>
