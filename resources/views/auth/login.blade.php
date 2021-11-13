<x-guest-layout>
    <div class="my-5 text-center">
        <span class="text-2xl font-bold">{{config('global.nama_gym')}}</span>
        <br><span class="font-semibold text-normal">Sistim Management GYM</span>

    </div>
    <x-card title="Login">
        <form method="POST" action="{{ route('login') }}">
            @csrf



            <div class="grid grid-cols-1 gap-3">
                <x-input name="email" placeholder="Email" />
                <x-input type="password" name="password" placeholder="****" />
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-button type="submit" label="log in" positive />
            </div>
        </form>

    </x-card>
</x-guest-layout>
