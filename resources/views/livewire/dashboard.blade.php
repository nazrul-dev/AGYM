<div>
  <div wire:poll>
    <div class="grid grid-cols-1 gap-4 md:grid-cols-4" >
        <div class="flex items-center p-3 space-x-5 bg-white border rounded-lg shadow">
            <div>
                <x-icon name="users" style="solid" class="w-12 h-12 text-green-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Total Member</h1>
                <h2 class="text-lg font-bold">{{ $member['total'] }}</h2>
            </div>
        </div>
        <div class="flex items-center p-3 space-x-5 bg-white border rounded-lg shadow">
            <div>
                <x-icon name="user" style="solid" class="w-12 h-12 text-green-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Member Active</h1>
                <h2 class="text-lg font-bold">{{ $member['active'] }}</h2>
            </div>
        </div>
        <div class="flex items-center p-3 space-x-5 bg-white border rounded-lg shadow">
            <div>
                <x-icon name="user" style="solid" class="w-12 h-12 text-red-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Member Nonaktif</h1>
                <h2 class="text-lg font-bold">{{ $member['expired'] }}</h2>
            </div>
        </div>
        <div class="flex items-center p-3 space-x-5 bg-white border rounded-lg shadow">
            <div>
                <x-icon name="cube" style="solid" class="w-12 h-12 text-green-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Total Produk</h1>
                <h2 class="text-lg font-bold">{{ $product }}</h2>
            </div>
        </div>

    </div>
    <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2">
        <div class="flex items-center p-3 space-x-5 bg-white border rounded-lg shadow">
            <div>
                <x-icon name="chevron-double-up" style="solid" class="w-12 h-12 text-green-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Pendapatan Hari ini</h1>
                <h2 class="text-lg font-bold">@rupiah($pendapatanToday)</h2>
            </div>
        </div>
        <div class="flex items-center p-3 space-x-5 bg-white border rounded-lg shadow">
            <div>
                <x-icon name="chevron-double-down" style="solid" class="w-12 h-12 text-red-600" />
            </div>
            <div>
                <h1 class="text-sm font-semibold">Pengeluaran Hari ini</h1>
                <h2 class="text-lg font-bold">@rupiah($pengeluaranToday)</h2>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2">
        <x-card title="Member Baru Hari ini">
            <div class="h-56 space-y-2 overflow-y-auto">
                @foreach ($newMember as $item)
                    <div class="p-3 border rounded-lg">
                        <span class="font-semibold">{{ $item->name }}</span><br>
                        <small>{{ $item->created_at->diffForHumans() }}</small>
                    </div>
                @endforeach
            </div>
        </x-card>
        <x-card title="Produk Terjual Hari ini">
            <div class="h-56 space-y-2 overflow-y-auto">
                @foreach ($saleToday as $sale)
                    @foreach ($sale->dec_orders as $order)
                        <div class="p-3 border rounded-lg">
                            <div class="flex justify-between">
                                <div>
                                    <span class="font-semibold">{{ $order['name'] }}</span><br>
                                    <small>{{ $order['quantity'] . ' PCS' }}</small>
                                </div>
                                <div>
                                    <p>Subtotal</p>
                                    <strong>
                                        @rupiah( $order['price'] * $order['quantity'])
                                    </strong>
                                </div>
                            </div>
                        </div>
                    @endforeach

                @endforeach
            </div>
        </x-card>
        <x-card title="Produk  Dengan Stok Toko Menipis">
            <div class="h-56 space-y-2 overflow-y-auto">
                @foreach ($stock['store'] as $item)
                    <div class="p-3 border rounded-lg">
                        <span class="font-semibold">{{ $item->product->name }}</span><br>
                        <small>{{ $item->total.' PCS' }}</small>
                    </div>
                @endforeach
            </div>
        </x-card>
        <x-card title="Produk  Dengan Stok Gudang Menipis">
            <div class="h-56 space-y-2 overflow-y-auto">
                @foreach ($stock['warehouse']  as $item)
                    <div class="p-3 border rounded-lg">
                        <span class="font-semibold">{{ $item->product->name }}</span><br>
                        <small>Tersisa :  {{ $item->total.' PCS' }}</small>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>
  </div>
</div>
