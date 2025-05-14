@extends($activeTemplate . 'layouts.master2')

@section('content')
<main class="p-2 sm:px-4 flex-1 overflow-auto bg-gray-50 text-gray-800">
    <div class="max-w-7xl mx-auto">
        <!-- Header with tabs navigation -->
        <div class="bg-white rounded-xl shadow-sm mb-6 p-4">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Portfolio Dashboard</h1>
                <div class="flex space-x-2">
                    <button id="refreshPrices" class="p-2 text-gray-500 hover:text-blue-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-all tooltip" data-tooltip="Refresh data">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </button>
                    <a href="{{ route('crypto.deposit.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Deposit</a>
                    <a href="{{ route('user.withdraw') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">Withdraw</a>
                </div>
            </div>
            
            <div class="border-b border-gray-200">
                <nav class="flex space-x-8">
                    <button data-tab="overviewTab" class="tab-button px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors">Overview</button>
                    <button data-tab="assetsTab" class="tab-button px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors">Assets</button>
                    <button data-tab="activityTab" class="tab-button px-4 py-2 text-gray-600 hover:text-gray-900 transition-colors">Recent Activity</button>
                </nav>
            </div>
        </div>
        
        <!-- Tab Contents -->
        <div id="overviewTab" class="tab-content">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Total Balance Card -->
                <div class="balance-card rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-2">
                        <h2 class="text-sm font-medium opacity-90">Total Balance</h2>
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-3xl font-bold mb-1">{{ showAmount(auth()->user()->balance) }}</p>
                    <p class="text-sm opacity-80">≈ ${{ showAmount(auth()->user()->balance * gs('usd_rate')) }} USD</p>
                    
                    <div class="flex items-center mt-4 text-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        <span>+2.45% last 24h</span>
                    </div>
                </div>
                
                <!-- Assets Summary -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-sm font-medium text-gray-500 mb-3">Assets Breakdown</h2>
                    <div class="space-y-3">
                        @foreach($topAssets->take(3) as $index => $asset)
                            @php
                                $symbollowcase = strtolower($asset->currency);
                                $colors = ['bg-blue-100 text-blue-800', 'bg-green-100 text-green-800', 'bg-purple-100 text-purple-800'];
                            @endphp
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 rounded-full {{ $colors[$index % 3] }} flex items-center justify-center mr-3">
                                        <img src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{{ $symbollowcase }}.svg" alt="{{ $asset->currency }}" class="w-4 h-4">
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $asset->currency }}</p>
                                        <p class="text-xs text-gray-500">{{ $asset->type }}</p>
                                    </div>
                                </div>
                                <span class="font-medium">{{ number_format($asset->amount, 2) }}</span>
                            </div>
                        @endforeach
                        
                        <a href="#" onclick="switchTab('assetsTab'); return false;" class="inline-block text-sm text-blue-600 hover:text-blue-800 mt-2">View all assets →</a>
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h2 class="text-sm font-medium text-gray-500 mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('crypto.deposit.index') }}" class="flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition">
                            <svg class="w-6 h-6 text-blue-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-sm font-medium">Deposit</span>
                        </a>
                        <a href="{{ route('user.withdraw') }}" class="flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition">
                            <svg class="w-6 h-6 text-gray-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-sm font-medium">Withdraw</span>
                        </a>
                        <a href="#" class="flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition">
                            <svg class="w-6 h-6 text-green-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            <span class="text-sm font-medium">Transfer</span>
                        </a>
                        <a href="#" class="flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 p-4 rounded-lg transition">
                            <svg class="w-6 h-6 text-purple-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span class="text-sm font-medium">History</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activities -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">Recent Activity</h2>
                    <a href="#" onclick="switchTab('activityTab'); return false;" class="text-sm text-blue-600 hover:text-blue-800">View all</a>
                </div>
                
                <div class="divide-y divide-gray-100">
                    <!-- Sample Activities - Replace with actual data as needed -->
                    <div class="py-3 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">Deposit</p>
                                <p class="text-xs text-gray-500">BTC • Today at 09:24 AM</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-green-600">+0.05 BTC</p>
                            <p class="text-xs text-gray-500">≈ $1,245.00</p>
                        </div>
                    </div>
                    
                    <div class="py-3 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">Withdrawal</p>
                                <p class="text-xs text-gray-500">ETH • Yesterday at 06:54 PM</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-red-600">-2.5 ETH</p>
                            <p class="text-xs text-gray-500">≈ $4,621.23</p>
                        </div>
                    </div>
                    
                    <div class="py-3 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">Transfer</p>
                                <p class="text-xs text-gray-500">XRP • 3 days ago</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-blue-600">+150 XRP</p>
                            <p class="text-xs text-gray-500">≈ $150.75</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Assets Tab -->
        <div id="assetsTab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">All Assets</h2>
                    <div class="relative">
                        <input type="text" id="assetSearch" placeholder="Search assets" class="search-input bg-gray-50 border border-gray-200 rounded-lg pl-10 pr-4 py-2 w-64 focus:outline-none focus:border-blue-500 transition">
                        <svg class="w-5 h-5 absolute left-3 top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Market Overview -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500 mb-1">BTC/USD</p>
                        <p class="text-xl font-bold">$28,356.41</p>
                        <p class="text-sm market-trend-positive">+1.24%</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500 mb-1">ETH/USD</p>
                        <p class="text-xl font-bold">$1,852.08</p>
                        <p class="text-sm market-trend-negative">-0.56%</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500 mb-1">XRP/USD</p>
                        <p class="text-xl font-bold">$0.5124</p>
                        <p class="text-sm market-trend-positive">+2.34%</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500 mb-1">SOL/USD</p>
                        <p class="text-xl font-bold">$26.85</p>
                        <p class="text-sm market-trend-positive">+5.12%</p>
                    </div>
                </div>
                
                <!-- Assets Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="text-gray-500 text-left text-sm">
                                <th class="py-3 px-4">Asset</th>
                                <th class="py-3 px-4">Type</th>
                                <th class="py-3 px-4">Price (USD)</th>
                                <th class="py-3 px-4">Holdings</th>
                                <th class="py-3 px-4">Value (USD)</th>
                                <th class="py-3 px-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($assets as $asset)
                                @php
                                    $symbollowcase = strtolower($asset->currency);
                                    $price = 0;
                                    try {
                                        $res = @file_get_contents("https://min-api.cryptocompare.com/data/price?fsym=" . strtoupper($asset->currency) . "&tsyms=USD");
                                        $decoded = json_decode($res, true);
                                        $price = isset($decoded['USD']) ? $decoded['USD'] : 0;
                                        $value = $price * $asset->amount;
                                    } catch (Exception $e) {
                                        $price = 0;
                                        $value = 0;
                                    }
                                @endphp
                                <tr class="asset-table-row asset-row hover:bg-gray-50">
                                    <td class="py-4 px-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mr-3">
                                                <img src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{{ $symbollowcase }}.svg" alt="{{ $asset->currency }}" class="w-6 h-6">
                                            </div>
                                            <div>
                                                <p class="font-medium asset-name">{{ $asset->currency }}</p>
                                                <p class="text-xs text-gray-500">{{ ucfirst($symbollowcase) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium">{{ $asset->type }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        @if($price > 0)
                                            <p class="font-medium">${{ number_format($price, 2) }}</p>
                                            <p class="text-xs text-green-600">+1.2% today</p>
                                        @else
                                            <p class="font-medium text-gray-400">Unavailable</p>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 font-medium">{{ number_format($asset->amount, 4) }} {{ $asset->currency }}</td>
                                    <td class="py-4 px-4 font-medium">
                                        @if($price > 0)
                                            ${{ number_format($value, 2) }}
                                        @else
                                            <span class="text-gray-400">--</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('crypto.deposit.index') }}" class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm">Deposit</a>
                                            <a href="{{ route('user.withdraw') }}" class="px-3 py-1 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition text-sm">Withdraw</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Activity Tab -->
        <div id="activityTab" class="tab-content hidden">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">Transaction History</h2>
                
                <!-- Filter Controls -->
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    <div class="relative">
                        <select class="appearance-none bg-gray-50 border border-gray-200 rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>All Types</option>
                            <option>Deposits</option>
                            <option>Withdrawals</option>
                            <option>Transfers</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <select class="appearance-none bg-gray-50 border border-gray-200 rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>All Assets</option>
                            <option>Bitcoin</option>
                            <option>Ethereum</option>
                            <option>XRP</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <select class="appearance-none bg-gray-50 border border-gray-200 rounded-lg pl-4 pr-10 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option>Last 30 days</option>
                            <option>Last 7 days</option>
                            <option>Last 24 hours</option>
                            <option>All time</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Transactions List -->
                <div class="divide-y divide-gray-100">
                    <!-- Sample Transactions - Replace with actual data -->
                    <div class="py-4 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">Deposit Bitcoin</p>
                                <p class="text-xs text-gray-500">Transaction ID: b2c4f8e9a3d5...</p>
                                <p class="text-xs text-gray-500">June 15, 2023 • 09:24 AM</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-green-600">+0.05 BTC</p>
                            <p class="text-sm text-gray-500">≈ $1,245.00</p>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium mt-1">Completed</span>
                        </div>
                    </div>
                    
                    <div class="py-4 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-red-100 text-red-600 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">Withdraw Ethereum</p>
                                <p class="text-xs text-gray-500">Transaction ID: a1b2c3d4e5f6...</p>
                                <p class="text-xs text-gray-500">June 14, 2023 • 06:54 PM</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-red-600">-2.5 ETH</p>
                            <p class="text-sm text-gray-500">≈ $4,621.23</p>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium mt-1">Completed</span>
                        </div>
                    </div>
                    
                    <div class="py-4 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">Transfer XRP</p>
                                <p class="text-xs text-gray-500">Transaction ID: x7y8z9a1b2...</p>
                                <p class="text-xs text-gray-500">June 12, 2023 • 11:32 AM</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-blue-600">+150 XRP</p>
                            <p class="text-sm text-gray-500">≈ $150.75</p>
                            <span class="inline-block px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-medium mt-1">Completed</span>
                        </div>
                    </div>
                    
                    <div class="py-4 flex justify-between items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium">Deposit Solana</p>
                                <p class="text-xs text-gray-500">Transaction ID: s9t8u7v6w5...</p>
                                <p class="text-xs text-gray-500">June 10, 2023 • 02:15 PM</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-amber-600">+10 SOL</p>
                            <p class="text-sm text-gray-500">≈ $268.50</p>
                            <span class="inline-block px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-medium mt-1">Pending</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('style')
<style>
    .tooltip {
        position: relative;
    }

    .tooltip:before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 8px;
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s, visibility 0.2s;
    }

    .tooltip:hover:before {
        opacity: 1;
        visibility: visible;
    }

    .asset-card {
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
    }
    
    .asset-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-left: 4px solid #3b82f6;
    }
    
    .tab-active {
        border-bottom: 2px solid #3b82f6;
        color: #1e3a8a;
        font-weight: 600;
    }
    
    .balance-card {
        background: linear-gradient(135deg, #2563eb, #1e40af);
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .balance-card::after {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
        pointer-events: none;
    }
    
    .market-trend-positive {
        color: #10b981;
    }
    
    .market-trend-negative {
        color: #ef4444;
    }
    
    .asset-row {
        transition: background-color 0.2s ease;
    }
    
    .asset-row:hover {
        background-color: #f1f5f9;
    }
    
    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.7; }
        100% { opacity: 1; }
    }
    
    .pulse-animation {
        animation: pulse 1.5s infinite ease-in-out;
    }
    
    .search-input:focus {
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
    }
</style>
@endpush

@push('script')
<script>
// Tab switching functionality
function switchTab(tabId) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Show the selected tab
    document.getElementById(tabId).classList.remove('hidden');
    
    // Update active tab
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('tab-active');
    });
    
    document.querySelector(`[data-tab="${tabId}"]`).classList.add('tab-active');
}

// Search functionality
function searchAssets() {
    const searchValue = document.getElementById('assetSearch').value.toLowerCase();
    const rows = document.querySelectorAll('.asset-table-row');
    
    rows.forEach(row => {
        const assetName = row.querySelector('.asset-name').textContent.toLowerCase();
        if (assetName.includes(searchValue)) {
            row.classList.remove('hidden');
        } else {
            row.classList.add('hidden');
        }
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Set overview tab as default
    switchTab('overviewTab');
    
    // Add search event listener
    document.getElementById('assetSearch').addEventListener('input', searchAssets);
    
    // Add refresh functionality for prices
    document.getElementById('refreshPrices').addEventListener('click', function() {
        const refreshIcon = this.querySelector('svg');
        refreshIcon.classList.add('animate-spin');
        
        // Simulate refresh with timeout
        setTimeout(() => {
            refreshIcon.classList.remove('animate-spin');
            // Add a notification or feedback here
        }, 1500);
    });
});

// Optional: Add chart functionality here if you add chart libraries
</script>
@endpush
@endsection
