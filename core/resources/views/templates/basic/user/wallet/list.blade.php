@extends($activeTemplate . 'layouts.master2')

@section('content')
<main class="p-2 sm:px-2 flex-1 overflow-auto bg-white text-black">
    <div class="grid grid-cols-1 ld:grid-cols-2 gap-12">
        <div class="p-4 rounded-lg shadow bg-white">
            <div class="container mx-auto p-4">
                <div class="mt-8">
                    <table class="min-w-full bg-white text-black">
                        <thead>
                            <tr class="text-black">
                                <th class="py-2 border border-gray-300">ID</th>
                                <th class="py-2 border border-gray-300">Currency</th>
                                <th class="py-2 border border-gray-300">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($wallets as $wallet)
                                @php
                                    $symbollowcase = strtolower($wallet->currency);
                                    $price = file_get_contents('https://min-api.cryptocompare.com/data/price?fsym=' . strtoupper($wallet->currency) . '&tsyms=USD');
                                    $priceData = json_decode($price, true);
                                    $price = $priceData['USD'] ?? 0;
                                    $usdBalance = $wallet->balance * $price;
                                @endphp
                                <tr class="text-black bg-white bg-opacity-10">
                                    <td class="border border-gray-300 px-4 py-2">{{ $wallet->id }}</td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <img src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{{ $symbollowcase }}.svg" alt="{{ $wallet->currency }}" class="inline-block h-6 w-6">
                                        {{ $wallet->currency }}
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        {{ number_format($wallet->balance, 4) }} {{ $wallet->currency }} <br>
                                        $ {{ number_format($usdBalance, 2) }}
                                        @if ($price == 0)
                                            <span class="text-xs text-red-500">(Price unavailable)</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
