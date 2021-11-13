<div>
    <div class="mb-10 text-center">
        <h1 class="text-xl font-black md:text-2xl">
            Pilih Tipe Transaksi Anda
        </h1>
        <h1>Pastikan Memilih Tipe Transaksi Sesuai Kebutuhan Anda</h1>
    </div>

    <div class="w-full mx-auto md:max-w-lg">
        <div class="grid grid-cols-1 gap-2 md:grid-cols-1">
            <a href="{{route('transaction.product')}}"
                class="font-medium text-white transform rounded shadow hover:scale-105 md:hover:scale-110 bg-gradient-to-r from-yellow-400 to-yellow-500">

                <div class="p-4">
                    <div class="flex flex-wrap items-center justify-between">
                        <x-icon name="shopping-cart" class="w-10 h-10 tetx-white" style="solid" />
                        <div>
                            <span class="text-lg font-semibold">Penjualan Produk</span>

                        </div>
                    </div>
                </div>
            </a>
            <a href="{{route('transaction.renew.member')}}"
                class="font-medium text-white transform rounded shadow hover:scale-105 md:hover:scale-110 bg-gradient-to-r from-blue-400 to-blue-500">

                <div class="p-4">
                    <div class="flex flex-wrap items-center justify-between">
                        <x-icon name="refresh" class="w-10 h-10 tetx-white" style="solid" />
                        <div>
                            <span class="text-lg font-semibold">Perpanjang Member</span>

                        </div>
                    </div>
                </div>
            </a>
            <a href="{{route('transaction.new.member')}}"
                class="font-medium text-white transform rounded shadow hover:scale-105 md:hover:scale-110 bg-gradient-to-r from-blue-400 to-blue-500">

                <div class="p-4">
                    <div class="flex flex-wrap items-center justify-between">
                        <x-icon name="user-add" class="w-10 h-10 tetx-white" style="solid" />
                        <div>
                            <span class="text-lg font-semibold"> Member Baru</span>

                        </div>
                    </div>
                </div>
            </a>
            <a href="{{route('transaction.cash')}}"
                class="font-medium text-white transform rounded shadow hover:scale-105 md:hover:scale-110 bg-gradient-to-r from-green-400 to-green-500">

                <div class="p-4">
                    <div class="flex flex-wrap items-center justify-between">
                        <x-icon name="chevron-double-up" class="w-10 h-10 tetx-white" style="solid" />
                        <div>
                            <span class="text-lg font-semibold"> Kas</span>

                        </div>
                    </div>
                </div>
            </a>

            <a href="{{route('transaction.rent')}}"
                class="font-medium text-white transform rounded shadow hover:scale-105 md:hover:scale-110 bg-gradient-to-r from-gray-400 to-gray-500">

                <div class="p-4">
                    <div class="flex flex-wrap items-center justify-between">
                        <x-icon name="user" class="w-10 h-10 tetx-white" style="solid" />
                        <div>
                            <span class="text-lg font-semibold"> Sewa GYM</span>

                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
