@extends($activeTemplate . 'layouts.master2')
@php
        $kyc = getContent('kyc.content', true);
    @endphp

<style>
     
    .tabs-container {
      width: 100%;
      max-width: 400px;
      background: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .tabs-header {
      display: flex;
      border-bottom: 2px solid #e0e0e0;
    }

    .tab-button {
      flex: 1;
      padding: 10px 15px;
      text-align: center;
      cursor: pointer;
      font-weight: bold;
      color: #555;
      border: none;
      outline: none;
      background: none;
      transition: color 0.3s, background-color 0.3s;
    }

    .tab-button.active {
      color: #ffffff;
      background: #26292c;
    }

    .tabs-content {
      padding: 20px;
    }

    .tab-content {
      display: none;
    }

    .tab-content.active {
      display: block;
    }
  </style>
@section('content')
<main class="p-2 sm:px-2 flex-1 overflow-auto">
 
    
    <div class="p-1 space-y-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-1">
            <!-- Chart and Trades Section -->
            <div class="lg:col-span-2 space-y-2">
                <!-- Trading Chart - Fixed sizing issues -->
                <div class="rounded-xl border border-gray-800 bg-black p-4 overflow-hidden">
                    <div class="tradingview-widget-container h-[610px] w-full">
                        <div id="tradingview_chart" class="tradingview-widget-container__widget h-full w-full"></div>
                        <div class="tradingview-widget-copyright hidden">
                            <a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank">
                                <span class="blue-text">Track all markets on TradingView</span>
                            </a>
                        </div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                        {
                            "height": "100%",
                            "width": "100%",
                            "symbol": "BINANCE:BTCUSDT",
                            "interval": "D",
                            "timezone": "Etc/UTC",
                            "theme": "dark",
                            "style": "1",
                            "locale": "en",
                            "hide_top_toolbar": false,
                            "allow_symbol_change": true,
                            "calendar": false,
                            "support_host": "https://www.tradingview.com"
                        }
                        </script>
                    </div>
                </div>

            </div>

            <!-- Trading Panel - Modernized UI -->
            <div class="rounded-xl border border-gray-800 bg-gray-900 p-6 shadow-lg">
                <form action="{{ route('user.trade.store') }}" method="post">
                    @csrf

                    <!-- Action Buttons with improved styling -->
                    <div class="flex gap-2 mb-6">
                        <div class="grid grid-cols-2 gap-2 w-full">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="action" value="buy" class="form-radio text-emerald-500 hidden" checked>
                                <span class="px-4 py-2.5 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition w-full text-center font-medium flex justify-center items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Buy
                                </span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="action" value="sell" class="form-radio text-red-500 hidden">
                                <span class="px-4 py-2.5 bg-red-500 text-white rounded-lg hover:bg-red-600 transition w-full text-center font-medium flex justify-center items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                    Sell
                                </span>
                            </label>
                        </div>
                    </div>

                    <!-- Conversion Buttons -->
                    <div class="grid grid-cols-2 gap-2 mb-6">
                        <button type="button" onclick="document.getElementById('fiatToCryptoModal').classList.remove('hidden')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 rounded-lg transition flex items-center justify-center gap-2 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            Fiat to Coin
                        </button>
                        <button type="button" onclick="document.getElementById('cryptoToFiatModal').classList.remove('hidden')" 
                                class="bg-green-600 hover:bg-green-700 text-white py-2.5 px-4 rounded-lg transition flex items-center justify-center gap-2 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Coin to Fiat
                        </button>
                    </div>

                    <div class="space-y-5">
                        <!-- Asset Type Select -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Asset Type</label>
                            <select class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent" name="trade_type" id="assetType">
                                <option value="Crypto">Cryptocurrencies</option>
                                <option value="Stocks">Stocks</option>
                                <option value="Forex">Forex</option>
                            </select>
                        </div>

                        <!-- Amount & Asset Selection - Improved -->
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-300 mb-1.5">Trading Amount</label>
                            <div class="flex items-center border border-gray-700 rounded-lg bg-gray-800 px-4 py-2.5 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent">
                                <input id="amount" type="text" name="amount" placeholder="0.00" 
                                    class="flex-1 bg-transparent outline-none text-white placeholder-gray-500" />
                                <div class="relative ml-2">
                                    <button id="dropdownButton" type="button" class="flex items-center justify-center space-x-2 text-sm bg-gray-700 px-2.5 py-1.5 rounded-lg hover:bg-gray-600 transition-colors">
                                        <img id="selectedIcon" src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/btc.svg" alt="BTC" class="w-5 h-5" />
                                        <span id="selectedSymbol" class="text-gray-200">BTC</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-1 text-gray-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    
                                    <!-- Dropdown Menu - Improved -->
                                    <div id="dropdownMenu" class="absolute z-10 hidden mt-2 w-64 bg-gray-800 border border-gray-700 rounded-lg shadow-lg right-0 overflow-auto max-h-64">
                                        <div class="p-2 border-b border-gray-700">
                                            <input type="text" id="assetSearch" placeholder="Search for assets" 
                                                class="w-full px-3 py-2 text-sm bg-gray-700 text-white rounded-lg border border-gray-600 placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:outline-none" />
                                        </div>
                                        <ul class="max-h-60 overflow-y-auto text-sm divide-y divide-gray-700" id="assetList">
                                            <!-- Assets will be loaded here by javascript -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="assets" id="selectedAssetSymbol" value="BTC" />
                        </div>
                        
                        <!-- Account Balance Info -->
                        <div class="bg-gray-800/50 border border-gray-700 rounded-lg p-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-400">Available Balance:</span>
                                <span class="text-base font-medium text-white">{{ showAmount(auth()->user()->balance) }} USD</span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-sm text-gray-400">Current Asset Price:</span>
                                <span class="text-base font-medium text-white" id="currentPrice">Loading...</span>
                            </div>
                        </div>

                        <!-- Stop Loss & Take Profit - Side by Side -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Stop Loss</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                    <input type="number" name="loss" value="6800" 
                                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2.5 pl-8 pr-3 text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1.5">Take Profit</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500">$</span>
                                    <input type="number" name="profit" value="32100" 
                                        class="w-full bg-gray-800 border border-gray-700 rounded-lg py-2.5 pl-8 pr-3 text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <!-- Trade Duration -->
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1.5">Duration</label>
                            <select class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-transparent" name="duration">
                                <option>2 minutes</option>
                                <option>5 minutes</option>
                                <option>10 minutes</option>
                                <option>15 minutes</option>
                                <option>30 minutes</option>
                                <option>1 hour</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 py-3 rounded-lg text-white font-medium transition-all shadow-lg hover:shadow-emerald-500/20" type="submit">
                            Place Trade
                        </button>
                    </div>
                </form>
            </div>
 
        </div>

        
        <!-- Trades Section - Improved UI -->
<div class="rounded-xl border border-gray-800 bg-gray-900 p-6 shadow-lg">
    <h2 class="text-xl font-bold text-white mb-5">Your Trades</h2>
    
    <!-- Improved Tabs -->
    <div class="flex space-x-1 mb-6 bg-gray-800 p-1 rounded-lg w-fit">
        <button class="px-5 py-2.5 text-sm font-medium rounded-lg bg-blue-600 text-white transition-colors" id="openTradesBtn">Active Trades</button>
        <button class="px-5 py-2.5 text-sm font-medium rounded-lg text-gray-300 hover:text-white hover:bg-gray-700 transition-colors" id="closedTradesBtn">Completed Trades</button>
    </div>

    <!-- Open Trades Table -->
    <div id="openTradesSection" class="overflow-hidden rounded-xl border border-gray-800">
        @if($userAssets->where('status', 'open')->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 px-4 bg-gray-800/50 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                <p class="text-gray-400 text-lg font-medium mb-1">No active trades</p>
                <p class="text-gray-500 text-sm">Start trading by placing your first order above.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-300">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-800 border-b border-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-4">Asset</th>
                            <th scope="col" class="px-6 py-4">Type</th>
                            <th scope="col" class="px-6 py-4">Amount</th>
                            <th scope="col" class="px-6 py-4">Take Profit</th>
                            <th scope="col" class="px-6 py-4">Stop Loss</th>
                            <th scope="col" class="px-6 py-4">Direction</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($userAssets->where('status', 'open') as $trade)
                            <tr class="bg-gray-800 hover:bg-gray-750 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $symbolLowercase = strtolower($trade->assets);
                                        $icon = $trade->assets;
                                        $icon2 = strtolower(substr($trade->assets, 0, 2));
                                        $iconSrc = '';

                                        if ($trade->trade_type == 'Crypto') {
                                            $iconSrc = "https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/svg/color/{$symbolLowercase}.svg";
                                        } elseif ($trade->trade_type == 'Stocks') {
                                            $iconSrc = "https://cdn.jsdelivr.net/gh/ahmeterenodaci/Nasdaq-Stock-Exchange-including-Symbols-and-Logos/logos/_{$icon}.png";
                                        } elseif ($trade->trade_type == 'Forex') {
                                            $iconSrc = "https://flagcdn.com/36x27/{$icon2}.png";
                                        }
                                    @endphp
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 flex-shrink-0 rounded-full bg-gray-700 flex items-center justify-center overflow-hidden">
                                            <img class="h-6 w-6 object-contain" src="{{ $iconSrc }}" alt="{{ $trade->assets }}"
                                                onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ $trade->assets }}&color=7F9CF5&background=172554&size=128';">
                                        </div>
                                        <span class="font-medium">{{ $trade->assets }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-md text-xs font-medium
                                        @if($trade->trade_type == 'Crypto') bg-blue-900/30 text-blue-400
                                        @elseif($trade->trade_type == 'Stocks') bg-purple-900/30 text-purple-400
                                        @else bg-amber-900/30 text-amber-400 @endif">
                                        {{ $trade->trade_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium">{{ number_format($trade->amount, 2) }}</td>
                                <td class="px-6 py-4 text-green-500">$ {{ $trade->profit }}</td>
                                <td class="px-6 py-4 text-red-500">$ {{ $trade->loss }}</td>
                                <td class="px-6 py-4">
                                    @if ($trade->action == 'buy')
                                        <span class="flex items-center text-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                                            </svg>
                                            Buy
                                        </span>
                                    @else
                                        <span class="flex items-center text-red-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M12 13a1 1 0 110 2H7a1 1 0 01-1-1V9a1 1 0 112 0v2.586l4.293-4.293a1 1 0 011.414 0L16 9.586 20.293 5.293a1 1 0 111.414 1.414l-5 5a1 1 0 01-1.414 0L13 9.414 9.414 13H12z" clip-rule="evenodd" />
                                            </svg>
                                            Sell
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-900/30 text-green-400">
                                        Active
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Closed Trades Table - Similar improvements -->
    <div id="closedTradesSection" class="hidden overflow-hidden rounded-xl border border-gray-800">
        @if($userAssets->where('status', 'complete')->isEmpty())
            <div class="flex flex-col items-center justify-center py-12 px-4 bg-gray-800/50 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-500 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-gray-400 text-lg font-medium mb-1">No completed trades</p>
                <p class="text-gray-500 text-sm">Your completed trades will appear here.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-300">
                    <thead class="text-xs text-gray-400 uppercase bg-gray-800 border-b border-gray-700">
                        <tr>
                            <th scope="col" class="px-6 py-4">Asset</th>
                            <th scope="col" class="px-6 py-4">Type</th>
                            <th scope="col" class="px-6 py-4">Amount</th>
                            <th scope="col" class="px-6 py-4">Take Profit</th>
                            <th scope="col" class="px-6 py-4">Stop Loss</th>
                            <th scope="col" class="px-6 py-4">Direction</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @foreach($userAssets->where('status', 'complete') as $trade)
                            <tr class="bg-gray-800 hover:bg-gray-750 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <!-- Similar asset display code as above -->
                                    <!-- ... -->
                                </td>
                                <!-- Other table cells similar to above -->
                                <!-- ... -->
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-900/30 text-blue-400">
                                        Completed
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

        <!-- Fiat to Crypto Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" id="fiatToCryptoModal">
            <div class="bg-gray-900 rounded-lg shadow-lg max-w-lg w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-white">Convert Fiat to Crypto</h3>
                    <button onclick="document.getElementById('fiatToCryptoModal').classList.add('hidden')" class="text-gray-400 hover:text-white">
                        ✖
                    </button>
                </div>
        
                <form action="{{ route('user.crypto.deposit.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="type" value="fiat_to_crypto">
        
                    <div>
                        <label for="f2c_fiatAmount" class="text-sm text-gray-300 block">Fiat Amount (USD)</label>
                        <input type="number" id="f2c_fiatAmount" name="fiat_amount" step="0.01" min="0"
                            class="w-full p-3 rounded-md bg-gray-800 text-white focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter amount in USD" required>
                    </div>
        
                    <div>
                        <label for="f2c_cryptoAmount" class="text-sm text-gray-300 block">You will receive</label>
                        <div class="flex items-center gap-2">
                            <input type="text" id="f2c_cryptoAmount" name="crypto_amount" readonly
                                class="flex-1 p-3 rounded-md bg-gray-800 text-white">
                            <span id="f2c_cryptoSymbol" class="text-white"></span>
                        </div>
                    </div>
        
                    <div>
                        <label for="f2c_cryptoSelect" class="text-sm text-gray-300 block">Select Cryptocurrency</label>
                        <div class="relative flex items-center bg-gray-800 rounded-md">
                            <img id="f2c_cryptoIcon" src="" class="w-8 h-8 ml-3" alt="Crypto Icon">
                            <select id="f2c_cryptoSelect" name="currency" class="w-full p-3 pl-12 bg-transparent text-black rounded-md focus:ring-2 focus:ring-blue-500" required>
                                @foreach($currencies as $crypto)
                                    <option value="{{ $crypto->symbol }}" data-icon="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/svg/color/{{ strtolower($crypto->symbol) }}.svg">
                                        {{ $crypto->name }} ({{ $crypto->symbol }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
        
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition">
                        Convert to Crypto
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Crypto to Fiat Modal -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden" id="cryptoToFiatModal">
            <div class="bg-gray-900 rounded-lg shadow-lg max-w-lg w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-white">Convert Crypto to Fiat</h3>
                    <button onclick="document.getElementById('cryptoToFiatModal').classList.add('hidden')" class="text-gray-400 hover:text-white">
                        ✖
                    </button>
                </div>
        
                <form action="{{ route('user.crypto.deposit.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="type" value="crypto_to_fiat">
        
                    <div>
                        <label for="c2f_cryptoSelect" class="text-sm text-gray-300 block">Select Cryptocurrency</label>
                        <div class="relative flex items-center bg-gray-800 rounded-md">
                            <img id="c2f_cryptoIcon" src="" class="w-8 h-8 ml-3" alt="Crypto Icon">
                            <select id="c2f_cryptoSelect" name="currency" class="w-full p-3 pl-12 bg-transparent text-black rounded-md focus:ring-2 focus:ring-blue-500" required>
                                @foreach($currencies as $crypto)
                                    <option value="{{ $crypto->symbol }}" data-icon="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/svg/color/{{ strtolower($crypto->symbol) }}.svg">
                                        {{ $crypto->name }} ({{ $crypto->symbol }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
        
                    <div>
                        <label for="c2f_cryptoAmount" class="text-sm text-gray-300 block">Crypto Amount</label>
                        <input type="number" id="c2f_cryptoAmount" name="crypto_amount" step="0.00000001" min="0"
                            class="w-full p-3 rounded-md bg-gray-800 text-white focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter crypto amount" required>
                    </div>
        
                    <div>
                        <label for="c2f_fiatAmount" class="text-sm text-gray-300 block">You will receive (USD)</label>
                        <input type="text" id="c2f_fiatAmount" name="fiat_amount" 
                            class="w-full p-3 rounded-md bg-gray-800 text-white" readonly>
                    </div>

                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg transition">
                        Convert to USD
                    </button>
                </form>
            </div>
        </div>
        
        <script>
            // Initialize Fiat to Crypto conversion
            document.addEventListener('DOMContentLoaded', function() {
                const f2c_fiatAmount = document.getElementById('f2c_fiatAmount');
                const f2c_cryptoAmount = document.getElementById('f2c_cryptoAmount');
                const f2c_cryptoSelect = document.getElementById('f2c_cryptoSelect');
                const f2c_cryptoIcon = document.getElementById('f2c_cryptoIcon');
                const f2c_cryptoSymbol = document.getElementById('f2c_cryptoSymbol');
        
                function updateF2CConversion() {
                    const fiatAmount = parseFloat(f2c_fiatAmount.value) || 0;
                    const cryptoSymbol = f2c_cryptoSelect.value;
        
                    if (fiatAmount <= 0 || !cryptoSymbol) {
                        f2c_cryptoAmount.value = '';
                        return;
                    }
        
                    fetch(`https://min-api.cryptocompare.com/data/price?fsym=${cryptoSymbol}&tsyms=USD`)
                        .then(response => response.json())
                        .then(data => {
                            const price = data.USD;
                            if (price && price > 0) {
                                const cryptoAmount = fiatAmount / price;
                                f2c_cryptoAmount.value = cryptoAmount.toFixed(8);
                                f2c_cryptoSymbol.textContent = cryptoSymbol;
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching crypto price:', error);
                            f2c_cryptoAmount.value = '';
                        });
                }
        
                f2c_fiatAmount.addEventListener('input', updateF2CConversion);
                f2c_cryptoSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    f2c_cryptoIcon.src = selectedOption.getAttribute('data-icon');
                    updateF2CConversion();
                });
        
                // Set initial crypto icon
                if (f2c_cryptoSelect.value) {
                    f2c_cryptoIcon.src = f2c_cryptoSelect.options[f2c_cryptoSelect.selectedIndex].getAttribute('data-icon');
                    updateF2CConversion();
                }
            });
        
            // Initialize Crypto to Fiat conversion
            document.addEventListener('DOMContentLoaded', function() {
                const c2f_cryptoAmount = document.getElementById('c2f_cryptoAmount');
                const c2f_fiatAmount = document.getElementById('c2f_fiatAmount');
                const c2f_cryptoSelect = document.getElementById('c2f_cryptoSelect');
                const c2f_cryptoIcon = document.getElementById('c2f_cryptoIcon');
        
                function updateC2FConversion() {
                    const cryptoAmount = parseFloat(c2f_cryptoAmount.value) || 0;
                    const cryptoSymbol = c2f_cryptoSelect.value;
        
                    if (cryptoAmount <= 0 || !cryptoSymbol) {
                        c2f_fiatAmount.value = '';
                        return;
                    }
        
                    fetch(`https://min-api.cryptocompare.com/data/price?fsym=${cryptoSymbol}&tsyms=USD`)
                        .then(response => response.json())
                        .then(data => {
                            const price = data.USD;
                            if (price && price > 0) {
                                const fiatAmount = cryptoAmount * price;
                                c2f_fiatAmount.value = `${fiatAmount.toFixed(2)}`;
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching crypto price:', error);
                            c2f_fiatAmount.value = '';
                        });
                }
        
                c2f_cryptoAmount.addEventListener('input', updateC2FConversion);
                c2f_cryptoSelect.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    c2f_cryptoIcon.src = selectedOption.getAttribute('data-icon');
                    updateC2FConversion();
                });
        
                // Set initial crypto icon
                if (c2f_cryptoSelect.value) {
                    c2f_cryptoIcon.src = c2f_cryptoSelect.options[c2f_cryptoSelect.selectedIndex].getAttribute('data-icon');
                }
            });
            
            // Add code for current price fetching
            document.addEventListener('DOMContentLoaded', function() {
                // Update asset price when asset changes
                function updateCurrentPrice(symbol) {
                    const priceDisplay = document.getElementById('currentPrice');
                    if (!symbol) return;
                    
                    priceDisplay.textContent = 'Loading...';
                    
                    // Determine API endpoint based on asset type
                    const assetType = document.getElementById('assetType').value;
                    let apiUrl;
                    
                    if (assetType === 'Crypto') {
                        apiUrl = `https://min-api.cryptocompare.com/data/price?fsym=${symbol}&tsyms=USD`;
                    } else {
                        // For stocks and forex, we would use different APIs in production
                        // For demo, we'll use a random price
                        const mockPrice = (Math.random() * 1000).toFixed(2);
                        priceDisplay.textContent = `$${mockPrice}`;
                        return;
                    }
                    
                    fetch(apiUrl)
                        .then(response => response.json())
                        .then(data => {
                            if (data.USD) {
                                priceDisplay.textContent = `$${data.USD.toLocaleString()}`;
                            } else {
                                priceDisplay.textContent = 'Price unavailable';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching price:', error);
                            priceDisplay.textContent = 'Price unavailable';
                        });
                }
                
                // Initialize with the default asset (BTC)
                updateCurrentPrice('BTC');
                
                // Update price when asset changes
                const selectedAssetSymbol = document.getElementById('selectedAssetSymbol');
                if (selectedAssetSymbol) {
                    selectedAssetSymbol.addEventListener('change', function() {
                        updateCurrentPrice(this.value);
                    });
                    
                    // Also watch for changes made programmatically
                    const observer = new MutationObserver(function(mutations) {
                        mutations.forEach(function(mutation) {
                            if (mutation.type === 'attributes' && mutation.attributeName === 'value') {
                                updateCurrentPrice(selectedAssetSymbol.value);
                            }
                        });
                    });
                    
                    observer.observe(selectedAssetSymbol, { attributes: true });
                }
            });
        </script>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Asset selection dropdown functionality
                // ...existing code...
                
                // Tabs for open and closed trades
                const openTradesBtn = document.getElementById('openTradesBtn');
                const closedTradesBtn = document.getElementById('closedTradesBtn');
                const openTradesSection = document.getElementById('openTradesSection');
                const closedTradesSection = document.getElementById('closedTradesSection');

                openTradesBtn.addEventListener('click', () => {
                    openTradesBtn.classList.add('bg-blue-600', 'text-white');
                    closedTradesBtn.classList.remove('bg-blue-600', 'text-white');
                    openTradesSection.classList.remove('hidden');
                    closedTradesSection.classList.add('hidden');
                });

                closedTradesBtn.addEventListener('click', () => {
                    closedTradesBtn.classList.add('bg-blue-600', 'text-white');
                    openTradesBtn.classList.remove('bg-blue-600', 'text-white');
                    closedTradesSection.classList.remove('hidden');
                    openTradesSection.classList.add('hidden');
                });
            });
        </script>
@endsection
