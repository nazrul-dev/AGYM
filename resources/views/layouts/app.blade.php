<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ config('global.nama_gym', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @stack('styles')
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body class="font-sans antialiased" x-data="sidebar()" @resize.window="sideResize()">
    <x-notifications z-index="z-50" />
    <x-dialog z-index="z-50" blur="md" align="center" />

    <div class="xl:flex">
        <div x-show="sideIsopenSide()" x-cloak
            x-transition:enter="transition-all ease-in-out duration-500 sm:duration-700"
            x-transition:enter-start="-ml-64" x-transition:enter-end="ml-0"
            x-transition:leave="transition-all ease-in-out duration-500 sm:duration-700" x-transition:leave-start="ml-0"
            x-transition:leave-end="-ml-64"
            class="fixed inset-0 z-20 flex min-h-screen bg-gray-900 bg-opacity-75 xl:static">
            <div class="text-white bg-gray-800 shadow w-72">
                <div class="flex content-between border-b-2 border-gray-600 border-dashed">
                    <div class="w-full p-3 font-semibold tracking-wider">{{ config('global.nama_gym') }}</div>
                    <a @click.prevent="sideClose()"
                        class="flex items-center flex-1 p-3 rounded-bl-xl hover:text-black hover:bg-gray-100" href="#">
                        <x-icon name="menu-alt-3" class="w-5 h-5" />
                    </a>
                </div>
                @auth
                <div class="py-6">
                    <ul class="flex flex-col w-full menu-list">
                        <li>
                            <a class="dropdown" href="{{ route('dashboard') }}">
                                <div class="dropdown-title">
                                    <x-icon name="home" style="solid" class="w-5 h-5" />
                                    <span class="font-semibold"> Dashboard</span>
                                </div>
                            </a>
                        </li>
                        @if (in_array(auth()->user()->role, ['master', 'operator']))
                            <li>
                                <a class="dropdown" href="javascript:void(0)">
                                    <div class="dropdown-title">
                                        <x-icon name="database" style="solid" class="w-5 h-5" />
                                        <span class="font-semibold"> Master</span>
                                    </div>

                                    <span class="icon"><i class="mdi mdi-plus"></i></span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('master.product') }}">
                                            <span>Produk</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('master.category') }}">
                                            <span>Kategori</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('master.staff') }}">
                                            <span>Staff</span>
                                        </a>
                                    </li>


                                </ul>

                            </li>

                            <li>
                                <a class="dropdown" href="javascript:void(0)">
                                    <div class="dropdown-title">
                                        <x-icon name="cube" style="solid" class="w-5 h-5" />
                                        <span class="font-semibold"> Stok</span>
                                    </div>

                                    <span class="icon"><i class="mdi mdi-plus"></i></span>
                                </a>
                                <ul>
                                    <li>
                                        <a href="{{ route('stocks.data', 'warehouse') }}">
                                            <span>Gudang</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('stocks.data', 'store') }}">
                                            <span>Toko</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li>
                            <a class="dropdown" href="javascript:void(0)">
                                <div class="dropdown-title">
                                    <x-icon name="switch-vertical" style="solid" class="w-5 h-5" />
                                    <span class="font-semibold"> Transaksi</span>
                                </div>

                                <span class="icon"><i class="mdi mdi-plus"></i></span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('transaction.select.type') }}">
                                        <span>Tambah Transaksi</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('transaction.data') }}">
                                        <span>Data Transaksi</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a class="dropdown" href="{{ route('loans.data') }}">
                                <div class="dropdown-title">
                                    <x-icon name="cash" style="solid" class="w-5 h-5" />
                                    <span class="font-semibold"> Piutang </span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown" href="javascript:void(0)">
                                <div class="dropdown-title">
                                    <x-icon name="users" style="solid" class="w-5 h-5" />
                                    <span class="font-semibold"> Member</span>
                                </div>

                                <span class="icon"><i class="mdi mdi-plus"></i></span>
                            </a>
                            <ul>

                                <li>
                                    <a href="{{ route('members.data') }}">
                                        <span>Data Member</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('members.expired') }}">
                                        <span>Expired Member</span>
                                    </a>
                                </li>


                            </ul>

                        </li>
                        @if (in_array(auth()->user()->role, ['master', 'operator']))
                            <li>
                                <a class="dropdown" href="{{ route('reports.transactions') }}">
                                    <div class="dropdown-title">
                                        <x-icon name="document-report" style="solid" class="w-5 h-5" />
                                        <span class="font-semibold"> laporan</span>
                                    </div>


                                </a>
                            </li>
                        @endif
                        <li>
                            <a class="dropdown" href="javascript:void(0)">
                                <div class="dropdown-title">
                                    <x-icon name="cog" style="solid" class="w-5 h-5" />
                                    <span class="font-semibold">Pengaturan</span>
                                </div>

                                <span class="icon"><i class="mdi mdi-plus"></i></span>
                            </a>
                            <ul>
                                @if (auth()->user()->role == 'master')
                                    <li>
                                        <a href="{{ route('setting', 'umum') }}">
                                            <span>Umum</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('setting', 'biaya') }}">
                                            <span>Biaya</span>
                                        </a>
                                    </li>
                                @endif
                                <li>
                                    <a href="{{ route('account') }}">
                                        <span>Akun</span>
                                    </a>
                                </li>

                            </ul>

                        </li>

                    </ul>

                </div>
                @endauth
            </div>
        </div>
        <div class="flex-1 h-screen overflow-y-auto">
            @auth
            <nav class="sticky top-0 z-10 flex items-center text-gray-700 bg-gray-100 ">
                <div x-show="!sideIsopenSide()" class="flex">
                    <a x-show="!sideIsopenSide()" @click.prevent="sideopenSide()"
                        class="p-3 text-white bg-gray-800 rounded-br-xl hover:bg-gray-900" href="#">
                        <x-icon name="menu-alt-2" class="w-5 h-5" />
                    </a>
                    <a class="p-3 ml-5 font-semibold tracking-wider hover:text-black" href="#">
                        {{ config('global.nama_gym') }}
                    </a>
                </div>
                <div class="flex items-center p-3 pr-2 ml-auto space-x-3 xl:pr-10">

                    <div>
                        <x-dropdown>
                            <x-slot name="trigger">
                                <div class="flex items-center space-x-2">
                                    <x-icon name="user-circle" class="w-6 h-6" />
                                    <div class="font-semibold">
                                        {{ auth()->user()->name }}
                                    </div>
                                </div>
                            </x-slot>


                            <x-dropdown.item href="{{ route('account') }}" label="Pengaturan Akun" />
                            <x-dropdown.item onClick="event.preventDefault(); document.getElementById('logout-form').submit();" separator label="Logout" />
                        </x-dropdown>
                    </div>
                </div>
            </nav>
            @endauth
            <main class="container mx-auto ">

                <div class="py-10 content">

                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>
    @auth
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    @endauth

    <!-- Scripts -->
    @wireUiScripts
    @livewireScripts
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('scripts')
    <script>
        function sidebar() {
            const breakpoint = 1280
            return {
                openSide: {
                    above: false,
                    below: true,
                },
                isAboveBreakpoint: window.innerWidth > breakpoint,

                sideResize() {
                    this.isAboveBreakpoint = window.innerWidth > breakpoint
                },

                sideIsopenSide() {
                    console.log(this.isAboveBreakpoint)
                    if (this.isAboveBreakpoint) {
                        return this.openSide.above
                    }
                    return this.openSide.below
                },
                sideopenSide() {
                    if (this.isAboveBreakpoint) {
                        this.openSide.above = true
                    }
                    this.openSide.below = true
                },
                sideClose() {
                    if (this.isAboveBreakpoint) {
                        this.openSide.above = false
                    }
                    this.openSide.below = false
                },
                sideAway() {
                    if (!this.isAboveBreakpoint) {
                        this.openSide.below = false
                    }
                },
            }
        }
    </script>
</body>

</html>
