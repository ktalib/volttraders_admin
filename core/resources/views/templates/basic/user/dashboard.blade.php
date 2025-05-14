@extends($activeTemplate . 'layouts.master2')
@php
    $kyc = getContent('kyc.content', true);
@endphp

<style>
    :root {
        --primary: #4361ee;
        --primary-dark: #3a56d4;
        --secondary: #3f37c9;
        --success: #4cc9f0;
        --danger: #f72585;
        --warning: #f8961e;
        --info: #4895ef;
        --light: #f8f9fa;
        --dark: #212529;
        --gray: #6c757d;
        --gray-light: #e9ecef;
        --white: #ffffff;
    }

    /* Base Styles */
    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: #f5f7fb;
        color: #1a1a1a;
        line-height: 1.6;
    }

    /* Card Styles */
    .dashboard-card {
        background: var(--white);
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.03);
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
    }

    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Typography */
    .text-heading {
        font-weight: 600;
        color: var(--dark);
    }

    .text-subheading {
        font-weight: 500;
        color: var(--gray);
        font-size: 0.875rem;
    }

    /* Tab Styles */
    .tab-nav {
        display: flex;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .tab-nav-item {
        padding: 0.75rem 1rem;
        font-weight: 500;
        color: var(--gray);
        cursor: pointer;
        position: relative;
        transition: all 0.2s ease;
    }

    .tab-nav-item:hover {
        color: var(--primary);
    }

    .tab-nav-item.active {
        color: var(--primary);
    }

    .tab-nav-item.active::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: var(--primary);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    /* Button Styles */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--primary);
        color: var(--white);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-success {
        background-color: var(--success);
        color: var(--white);
    }

    .btn-danger {
        background-color: var(--danger);
        color: var(--white);
    }

    .btn-outline {
        background-color: transparent;
        border: 1px solid var(--gray-light);
        color: var(--gray);
    }

    .btn-outline:hover {
        background-color: var(--gray-light);
    }

    /* Form Styles */
    .form-control {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid var(--gray-light);
        border-radius: 8px;
        transition: all 0.2s ease;
        background-color: var(--white);
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        outline: none;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--dark);
        font-size: 0.875rem;
    }

    /* Table Styles */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background-color: #f8fafc;
        color: var(--gray);
        font-weight: 600;
        text-align: left;
        padding: 0.75rem 1rem;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        vertical-align: middle;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    .data-table tr:hover {
        background-color: #f8fafc;
    }

    /* Badge Styles */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .badge-success {
        background-color: #e6f7ee;
        color: #059669;
    }

    .badge-danger {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .badge-warning {
        background-color: #fef3c7;
        color: #d97706;
    }

    .badge-info {
        background-color: #dbeafe;
        color: #2563eb;
    }

    /* Progress Bars */
    .progress-container {
        height: 8px;
        border-radius: 4px;
        background-color: var(--gray-light);
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        border-radius: 4px;
        transition: width 0.6s ease;
    }

    /* Crypto Icons */
    .crypto-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        background-color: #f8fafc;
        overflow: hidden;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-content {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px;
        transform: translateY(20px);
        transition: all 0.3s ease;
    }

    .modal-overlay.active .modal-content {
        transform: translateY(0);
    }

    .modal-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-close {
        color: var(--gray);
        font-size: 1.5rem;
        cursor: pointer;
        transition: color 0.2s ease;
    }

    .modal-close:hover {
        color: var(--dark);
    }

    /* Signal Bars */
    .signal-bars {
        display: flex;
        gap: 4px;
        height: 8px;
    }

    .signal-bar {
        flex: 1;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
    }

    .empty-state-icon {
        font-size: 3rem;
        color: var(--gray-light);
        margin-bottom: 1rem;
    }

    .empty-state-text {
        color: var(--gray);
        margin-bottom: 1.5rem;
    }

    /* Responsive Grid */
    .grid-container {
        display: grid;
        gap: 1.5rem;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    }

    /* Animations */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .animate-fade {
        animation: fadeIn 0.3s ease-out;
    }

    /* Utility Classes */
    .text-success {
        color: #10b981;
    }

    .text-danger {
        color: #ef4444;
    }

    .text-warning {
        color: #f59e0b;
    }

    .bg-success-light {
        background-color: #d1fae5;
    }

    .bg-danger-light {
        background-color: #fee2e2;
    }

    .bg-warning-light {
        background-color: #fef3c7;
    }

    .bg-info-light {
        background-color: #dbeafe;
    }

    /* Trading View Widget */
    .tradingview-widget-container {
        height: 100%;
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
    }
</style>

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Dashboard Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Dashboard Overview</h1>
        <p class="text-white">Welcome back, {{ auth()->user()->username }}</p>
    </div>

    <!-- Balance and Stats Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Balance Card -->
        <div class="dashboard-card">
            <div class="card-header">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-subheading">Total Balance</h3>
                        <p class="text-heading text-2xl">{{ showAmount(auth()->user()->balance) }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <button class="p-2 rounded-lg tab-nav-item active" data-tab="tab1">
                            <i class="ri-file-list-line"></i>
                        </button>
                        <button class="p-2 rounded-lg tab-nav-item" data-tab="tab2">
                            <i class="ri-smartphone-line"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div id="tab1" class="tab-content active animate-fade">
                    <h4 class="text-subheading mb-3">Recent Deposits</h4>
                    <div class="space-y-3">
                        @foreach($Topcurrencies as $currency)
                            @php
                                $symbollowcase = strtolower($currency->currency);
                                $apiUrl = "https://min-api.cryptocompare.com/data/price?fsym={$currency->currency}&tsyms=USD";
                                $response = file_get_contents($apiUrl);
                                $data = json_decode($response, true);
                                $rate = $data['USD'] ?? 0;
                                $amount_usd = $currency->amount * $rate;
                            @endphp
                            
                            <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="flex items-center">
                                    <div class="crypto-icon">
                                        <img src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{{ $symbollowcase }}.svg" 
                                             class="w-4 h-4" 
                                             onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/0/381.png'">
                                    </div>
                                    <div>
                                        <div class="text-heading">{{ $currency->currency }}</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-heading">${{ number_format($amount_usd, 2) }}</div>
                                    <div class="text-subheading">{{ $currency->amount }} {{ $currency->currency }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
           
                <div id="tab2" class="tab-content animate-fade">
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <div class="flex items-center">
                                <i class="ri-currency-line text-gray-400 mr-2"></i>
                                <span class="text-subheading">Total Deposits</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <p class="text-heading">{{ showAmount(auth()->user()->balance) }}</p>
                                <a href="{{ route('crypto.deposit.index') }}" class="btn btn-primary text-sm">Deposit</a>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <div class="flex items-center">
                                <i class="ri-currency-line text-gray-400 mr-2"></i>
                                <span class="text-subheading">Total Withdrawals</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <p class="text-heading">{{ showAmount($totalWithdraw) }}</p>
                                <a href="{{ route('user.withdraw') }}" class="btn btn-primary text-sm">Withdraw</a>
                            </div>
                        </div>
                
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <div class="flex items-center">
                                <i class="ri-currency-line text-gray-400 mr-2"></i>
                                <span class="text-subheading">Total Profits</span>
                            </div>
                            <p class="text-heading">$0.00</p>
                        </div>
                
                        <div class="flex justify-between items-center py-3">
                            <div class="flex items-center">
                                <i class="ri-shield-check-line text-gray-400 mr-2"></i>
                                <span class="text-subheading">Verification</span>
                            </div>
                            @if (auth()->user()->kv == Status::KYC_UNVERIFIED && auth()->user()->kyc_rejection_reason)
                                <div class="p-3 bg-danger-light text-danger rounded-lg text-sm">
                                    <div class="flex justify-between items-center">
                                        <h4 class="font-bold">@lang('KYC Documents Rejected')</h4>
                                    </div>
                                    <hr class="my-2 border-gray-200">
                                    <p class="mb-0">
                                        {{ __(@$kyc->data_values->reject) }} 
                                        <a href="javascript::void(0)" class="text-primary underline" data-bs-toggle="modal" data-bs-target="#kycRejectionReason">@lang('Click here')</a> 
                                        @lang('to show the reason'). 
                                        <a href="{{ route('user.kyc.form') }}" class="text-primary underline">@lang('Click Here')</a> 
                                        @lang('to Re-submit Documents'). 
                                        <a class="text-primary underline" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                                    </p>
                                </div>
                            @elseif(auth()->user()->kv == Status::KYC_UNVERIFIED)
                                <div class="p-3 bg-warning-light text-warning rounded-lg text-sm">
                                    <h4 class="font-bold">@lang('KYC Verification Required')</h4>
                                    <hr class="my-2 border-gray-200">
                                    <p class="mb-0">
                                        {{ __(@$kyc->data_values->required) }} 
                                        <a class="text-primary underline" href="{{ route('user.kyc.form') }}">@lang('Click Here to Submit Documents')</a>
                                    </p>
                                </div>
                            @elseif(auth()->user()->kv == Status::KYC_PENDING)
                                <div class="p-3 bg-info-light text-info rounded-lg text-sm">
                                    <h4 class="font-bold">@lang('KYC Verification Pending')</h4>
                                    <hr class="my-2 border-gray-200">
                                    <p class="mb-0">
                                        {{ __(@$kyc->data_values->pending) }} 
                                        <a class="text-primary underline" href="{{ route('user.kyc.data') }}">@lang('See KYC Data')</a>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="dashboard-card">
            <div class="card-body space-y-6">
                <!-- Categories Card -->
                <div>
                    <h3 class="text-subheading mb-3">Portfolio Allocation</h3>
                    @php
                        $totalTradeAmount = $userAssets->sum('amount');
                        $cryptoTrades = $userAssets->where('trade_type', 'Crypto')->sum('amount');
                        $stockTrades = $userAssets->where('trade_type', 'Stocks')->sum('amount');
                        $forexTrades = $userAssets->where('trade_type', 'Forex')->sum('amount');
                        
                        $cryptoPercent = $totalTradeAmount > 0 ? ($cryptoTrades / $totalTradeAmount) * 100 : 0;
                        $stockPercent = $totalTradeAmount > 0 ? ($stockTrades / $totalTradeAmount) * 100 : 0;
                        $forexPercent = $totalTradeAmount > 0 ? ($forexTrades / $totalTradeAmount) * 100 : 0;
                    @endphp

                    @if($totalTradeAmount > 0)
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-subheading">Crypto</span>
                                    <span class="text-heading">{{ number_format($cryptoPercent, 1) }}%</span>
                                </div>
                                <div class="progress-container">
                                    <div class="progress-bar bg-primary" style="width: {{ $cryptoPercent }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-subheading">Stocks</span>
                                    <span class="text-heading">{{ number_format($stockPercent, 1) }}%</span>
                                </div>
                                <div class="progress-container">
                                    <div class="progress-bar bg-success" style="width: {{ $stockPercent }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="text-subheading">Forex</span>
                                    <span class="text-heading">{{ number_format($forexPercent, 1) }}%</span>
                                </div>
                                <div class="progress-container">
                                    <div class="progress-bar bg-info" style="width: {{ $forexPercent }}%"></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <p class="text-subheading">
                            No categories yet.
                            <a href="{{ route('crypto.deposit.index') }}" class="text-primary hover:underline">Deposit now</a>
                            to see your portfolio breakdown.
                        </p>
                    @endif
                </div>

                <!-- Trading Progress Card -->
                <div>
                    <h3 class="text-subheading mb-3">Trading Performance</h3>
                    @php
                        $completedTrades = $userAssets->where('status', 'complete')->count();
                        $totalTrades = $userAssets->count();
                        $progressPercent = $totalTrades > 0 ? ($completedTrades / $totalTrades) * 100 : 0;
                    @endphp
                    <div class="progress-container">
                        <div class="progress-bar bg-success" style="width: {{ $progressPercent }}%"></div>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span class="text-subheading text-xs">{{ $completedTrades }} completed</span>
                        <span class="text-subheading text-xs">{{ $totalTrades }} total</span>
                    </div>
                </div>

                <!-- Signal Strength Card -->
                <div>
                    <h3 class="text-subheading mb-3">Market Signal Strength</h3>
                    @php
                        $signalStrength = 10; // This should be dynamic in your actual implementation
                        $barCount = 5;
                        $activeBarCount = ceil(($signalStrength / 100) * $barCount);
                    @endphp
                    <div class="signal-bars" id="signal-bars">
                        @for ($i = 1; $i <= $barCount; $i++)
                            @if ($i <= $activeBarCount)
                                <div class="signal-bar" 
                                    style="background-color: {{ $i <= 1 ? 'var(--danger)' : ($i <= 3 ? 'var(--warning)' : 'var(--success)') }};"></div>
                            @else
                                <div class="signal-bar bg-gray-200"></div>
                            @endif
                        @endfor
                    </div>
                    <div class="flex justify-between mt-1">
                        <span class="text-subheading text-xs">Low</span>
                        <span class="text-xs font-medium signal-strength-value {{ $signalStrength > 50 ? 'text-success' : 'text-danger' }}">
                            {{ $signalStrength }}%
                        </span>
                        <span class="text-subheading text-xs">High</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart and Trading Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Chart Section -->
        <div class="lg:col-span-2">
            <div class="dashboard-card h-full">
                <div class="card-header">
                    <h3 class="text-heading">Market Chart</h3>
                </div>
                <div class="card-body p-0 h-[400px]">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
                        <div class="tradingview-widget-copyright">
                            <a href="https://www.tradingview.com/" rel="noopener nofollow" target="_blank">
                                <span class="blue-text">Track all markets on TradingView</span>
                            </a>
                        </div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                            {
                                "height": "400",
                                "symbol": "BINANCE:BTCUSDT",
                                "interval": "D",
                                "timezone": "Etc/UTC",
                                "theme": "light",
                                "style": "1",
                                "locale": "en",
                                "hide_top_toolbar": true,
                                "allow_symbol_change": true,
                                "calendar": false,
                                "support_host": "https://www.tradingview.com"
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
            </div>
        </div>

        <!-- Trading Panel -->
        <div class="dashboard-card">
            <div class="card-header">
                <h3 class="text-heading">New Trade</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('user.trade.store') }}" method="post" id="tradeForm">
                    @csrf
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <!-- Buy Button -->
                        <label class="flex-1">
                            <input type="radio" name="action" value="buy" class="hidden peer" checked>
                            <span class="btn btn-primary w-full text-center peer-checked:bg-primary-dark">Buy</span>
                        </label>
                        
                        <!-- Sell Button -->
                        <label class="flex-1">
                            <input type="radio" name="action" value="sell" class="hidden peer">
                            <span class="btn btn-danger w-full text-center peer-checked:bg-red-700">Sell</span>
                        </label>
                        
                        <!-- Fiat to Coin Button -->
                        <button type="button" onclick="openModal('fiatToCryptoModal')" 
                                class="btn btn-primary w-full text-center">
                            Fiat to Coin
                        </button>
                        
                        <!-- Coin to Fiat Button -->
                        <button type="button" onclick="openModal('cryptoToFiatModal')" 
                                class="btn btn-success w-full text-center">
                            Coin to Fiat
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="form-label">Trade Type:</label>
                            <select class="form-control" name="trade_type" id="assetType">
                                <option value="Crypto">Crypto</option>
                                <option value="Stocks">Stocks</option>
                                <option value="Forex">Forex</option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Asset:</label>
                            <div class="relative">
                                <div class="flex items-center border border-gray-200 rounded-lg bg-white text-gray-900 px-3 py-2">
                                    <input id="amount" type="text" name="amount" placeholder="100" class="flex-1 bg-transparent outline-none text-gray-900 placeholder-gray-400" />
                                    <div class="relative ml-2">
                                        <button id="dropdownButton" type="button" class="flex items-center justify-center space-x-2 text-sm bg-gray-100 px-3 py-1.5 rounded-lg hover:bg-gray-200">
                                            <img id="selectedIcon" src="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/btc.svg" alt="BTC" class="w-4 h-4" />
                                            <span id="selectedSymbol" class="text-gray-700">BTC</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-1 text-gray-500">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <div id="dropdownMenu" class="absolute z-10 hidden mt-1 w-64 bg-white border border-gray-200 rounded-lg shadow-lg left-0 md:left-auto md:right-0 overflow-auto max-h-60">
                                            <div class="p-2 border-b border-gray-200">
                                                <input type="text" id="assetSearch" placeholder="Search for assets" class="w-full px-3 py-2 text-sm bg-gray-50 text-gray-900 rounded-lg border border-gray-200 placeholder-gray-500 focus:ring-1 focus:ring-blue-500 focus:outline-none" />
                                            </div>
                                            <ul class="max-h-52 overflow-y-auto text-sm" id="assetList">
                                                {{-- Assets will be loaded here by javascript --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="assets" id="selectedAssetSymbol" value="BTC" />
                            </div>
                        </div>

                        <div>
                            <label class="text-subheading">Current USD Balance: <span class="text-heading">{{ showAmount(auth()->user()->balance) }}</span></label>
                        </div>
                        <div>
                            <label class="text-subheading">Current Asset Price: <span id="currentAssetPrice" class="text-heading">$0.00</span></label>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="form-label">Stop Loss:</label>
                                <input type="number" name="loss" value="6800" class="form-control">
                            </div>
                            <div>
                                <label class="form-label">Take Profit:</label>
                                <input type="number" name="profit" value="32100" class="form-control">
                            </div>
                        </div>

                        <div>
                            <label class="form-label">Duration:</label>
                            <select class="form-control" name="duration">
                                <option value="2">2 minutes</option>
                                <option value="5">5 minutes</option>
                                <option value="10">10 minutes</option>
                            </select>
                        </div>

                        <button class="w-full btn btn-primary py-3 rounded-lg font-medium mt-4" type="submit" id="submitTrade">
                            Place Trade
                        </button>
                    </div>
                </form> 
            </div>
        </div>
    </div>

    <!-- Trades Section -->
    <div class="dashboard-card">
        <div class="card-header">
            <div class="flex justify-between items-center">
                <h3 class="text-heading">Trade History</h3>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 text-sm bg-primary text-white rounded-md font-medium" id="openTradesBtn">Open</button>
                    <button class="px-4 py-2 text-sm text-gray-600 hover:text-gray-900 bg-gray-100 rounded-md font-medium" id="closedTradesBtn">Completed</button>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <!-- Open Trades Table -->
            <div id="openTradesSection">
                @if($userAssets->where('status', 'open')->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="ri-exchange-funds-line"></i>
                        </div>
                        <p class="empty-state-text">No open trades yet.</p>
                        <button class="btn btn-primary inline-flex items-center" onclick="document.getElementById('tradeForm').scrollIntoView()">
                            <i class="ri-add-line mr-1"></i> Place a Trade
                        </button>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Asset</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Loss/Profit</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userAssets->where('status', 'open') as $trade)
                                <tr>
                                    <td> 
                                        @php
                                            $symbollowcase = strtolower($trade->assets);
                                            $icon = $trade->assets;
                                            $icon2 = strtolower(substr($trade->assets, 0, 2));
                                            $iconSrc = '';

                                            if ($trade->trade_type == 'Crypto') {
                                                $iconSrc = "https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{$symbollowcase}.svg";
                                            } elseif ($trade->trade_type == 'Stocks') {
                                                $iconSrc = "https://cdn.jsdelivr.net/gh/ahmeterenodaci/Nasdaq-Stock-Exchange-including-Symbols-and-Logos/logos/_{$icon}.png";
                                            } elseif ($trade->trade_type == 'Forex') {
                                                $iconSrc = "https://flagcdn.com/36x27/{$icon2}.png";
                                            }
                                        @endphp
                                        <div class="flex items-center">
                                            <img class="w-6 h-6 rounded-full mr-2" src="{{ $iconSrc }}" alt="{{ $trade->assets }}" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/0/381.png'"> 
                                            <span>{{ $trade->assets }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $trade->trade_type }}</td>
                                    <td>${{ number_format($trade->amount, 2) }}</td>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-success">${{ $trade->profit }}</span>
                                            <span class="text-danger">${{ $trade->loss }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($trade->action == 'buy')
                                            <span class="badge badge-success">Buy</span>
                                        @else
                                            <span class="badge badge-danger">Sell</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($trade->status == 'open')
                                            <span class="badge badge-success">Open</span>
                                        @else
                                            <span class="badge badge-danger">Closed</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Closed Trades Table -->
            <div id="closedTradesSection" class="hidden">
                @if($userAssets->where('status', 'complete')->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="ri-exchange-funds-line"></i>
                        </div>
                        <p class="empty-state-text">No completed trades yet.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Asset</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Loss/Profit</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userAssets->where('status', 'complete') as $trade)
                                <tr>
                                    <td>
                                        @php
                                            $symbollowcase = strtolower($trade->assets);
                                            $icon = $trade->assets;
                                            $icon2 = strtolower(substr($trade->assets, 0, 2));
                                            $iconSrc = '';

                                            if ($trade->trade_type == 'Crypto') {
                                                $iconSrc = "https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{$symbollowcase}.svg";
                                            } elseif ($trade->trade_type == 'Stocks') {
                                                $iconSrc = "https://cdn.jsdelivr.net/gh/ahmeterenodaci/Nasdaq-Stock-Exchange-including-Symbols-and-Logos/logos/_{$icon}.png";
                                            } elseif ($trade->trade_type == 'Forex') {
                                                $iconSrc = "https://flagcdn.com/36x27/{$icon2}.png";
                                            }
                                        @endphp
                                        <div class="flex items-center">
                                            <img class="w-6 h-6 rounded-full mr-2" src="{{ $iconSrc }}" alt="{{ $trade->assets }}" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/0/381.png'"> 
                                            <span>{{ $trade->assets }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $trade->trade_type }}</td>
                                    <td>${{ number_format($trade->amount, 2) }}</td>
                                    <td>
                                        <div class="flex flex-col">
                                            <span class="text-success">${{ $trade->profit }}</span>
                                            <span class="text-danger">${{ $trade->loss }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($trade->action == 'buy')
                                            <span class="badge badge-success">Buy</span>
                                        @else
                                            <span class="badge badge-danger">Sell</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-success">Completed</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Fiat to Crypto Modal -->
<div class="modal-overlay" id="fiatToCryptoModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-heading">Convert Fiat to Crypto</h3>
            <button onclick="closeModal('fiatToCryptoModal')" class="modal-close">
                ✖
            </button>
        </div>
    
        <div class="modal-body">
            <form action="{{ route('user.crypto.deposit.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="fiat_to_crypto">
    
                <div>
                    <label for="f2c_fiatAmount" class="form-label">Fiat Amount (USD)</label>
                    <input type="number" id="f2c_fiatAmount" name="fiat_amount" step="0.01" min="0"
                        class="form-control"
                        placeholder="Enter amount in USD" required>
                </div>
    
                <div>
                    <label for="f2c_cryptoAmount" class="form-label">You will receive</label>
                    <div class="flex items-center gap-2">
                        <input type="text" id="f2c_cryptoAmount" name="crypto_amount" readonly
                            class="form-control bg-gray-50">
                        <span id="f2c_cryptoSymbol" class="text-heading"></span>
                    </div>
                </div>
    
                <div>
                    <label for="f2c_cryptoSelect" class="form-label">Select Cryptocurrency</label>
                    <div class="relative flex items-center bg-gray-50 rounded-lg border border-gray-300">
                        <img id="f2c_cryptoIcon" src="" class="w-6 h-6 ml-3" alt="Crypto Icon">
                        <select id="f2c_cryptoSelect" name="currency" class="w-full py-2 px-3 pl-12 bg-transparent text-gray-900 rounded-lg focus:ring-1 focus:ring-blue-500 focus:outline-none" required>
                            @foreach($currencies as $crypto)
                                <option value="{{ $crypto->symbol }}" data-icon="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/svg/color/{{ strtolower($crypto->symbol) }}.svg">
                                    {{ $crypto->name }} ({{ $crypto->symbol }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <button type="submit" class="w-full btn btn-primary py-3 rounded-lg mt-4">
                    Convert to Crypto
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Crypto to Fiat Modal -->
<div class="modal-overlay" id="cryptoToFiatModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="text-heading">Convert Crypto to Fiat</h3>
            <button onclick="closeModal('cryptoToFiatModal')" class="modal-close">
                ✖
            </button>
        </div>
    
        <div class="modal-body">
            <form action="{{ route('user.crypto.deposit.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="crypto_to_fiat">
    
                <div>
                    <label for="c2f_cryptoSelect" class="form-label">Select Cryptocurrency</label>
                    <div class="relative flex items-center bg-gray-50 rounded-lg border border-gray-300">
                        <img id="c2f_cryptoIcon" src="" class="w-6 h-6 ml-3" alt="Crypto Icon">
                        <select id="c2f_cryptoSelect" name="currency" class="w-full py-2 px-3 pl-12 bg-transparent text-gray-900 rounded-lg focus:ring-1 focus:ring-blue-500 focus:outline-none" required>
                            @foreach($currencies as $crypto)
                                <option value="{{ $crypto->symbol }}" data-icon="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/master/svg/color/{{ strtolower($crypto->symbol) }}.svg">
                                    {{ $crypto->name }} ({{ $crypto->symbol }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div>
                    <label for="c2f_cryptoAmount" class="form-label">Crypto Amount</label>
                    <input type="number" id="c2f_cryptoAmount" name="crypto_amount" step="0.00000001" min="0"
                        class="form-control"
                        placeholder="Enter crypto amount" required>
                </div>
    
                <div>
                    <label for="c2f_fiatAmount" class="form-label">You will receive (USD)</label>
                    <input type="text" id="c2f_fiatAmount" name="fiat_amount" 
                        class="form-control bg-gray-50" readonly>
                </div>
    
                <button type="submit" class="w-full btn btn-success py-3 rounded-lg mt-4">
                    Convert to USD
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    // Modal functions
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        document.body.style.overflow = 'hidden';
    }
    
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.style.overflow = '';
    }
    
    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            closeModal(event.target.id);
        }
    }

    // Tab switching
    const tabButtons = document.querySelectorAll('.tab-nav-item');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach((button) => {
        button.addEventListener('click', () => {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));

            button.classList.add('active');
            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Trade table switching
    document.getElementById('openTradesBtn').addEventListener('click', function() {
        this.classList.add('bg-primary', 'text-white');
        this.classList.remove('text-gray-600', 'bg-gray-100');
        document.getElementById('closedTradesBtn').classList.remove('bg-primary', 'text-white');
        document.getElementById('closedTradesBtn').classList.add('text-gray-600', 'bg-gray-100');
        document.getElementById('openTradesSection').classList.remove('hidden');
        document.getElementById('closedTradesSection').classList.add('hidden');
    });

    document.getElementById('closedTradesBtn').addEventListener('click', function() {
        this.classList.add('bg-primary', 'text-white');
        this.classList.remove('text-gray-600', 'bg-gray-100');
        document.getElementById('openTradesBtn').classList.remove('bg-primary', 'text-white');
        document.getElementById('openTradesBtn').classList.add('text-gray-600', 'bg-gray-100');
        document.getElementById('closedTradesSection').classList.remove('hidden');
        document.getElementById('openTradesSection').classList.add('hidden');
    });

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
                        c2f_fiatAmount.value = `$${fiatAmount.toFixed(2)}`;
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

    // Asset selection dropdown
    document.addEventListener('DOMContentLoaded', function() {
        const dropdownButton = document.getElementById("dropdownButton");
        const dropdownMenu = document.getElementById("dropdownMenu");
        const selectedIcon = document.getElementById("selectedIcon");
        const selectedSymbol = document.getElementById("selectedSymbol");
        const selectedAssetSymbol = document.getElementById("selectedAssetSymbol");
        const assetSearch = document.getElementById("assetSearch");
        const assetType = document.getElementById("assetType");
        const assetList = document.getElementById("assetList");
        const currentAssetPrice = document.getElementById("currentAssetPrice");

        let stocksData = [];
        let forexData = [];

        // Fetch stock data
        fetch('https://tradededpro.com/app/assets/global/jsons/stock.json')
            .then(response => response.json())
            .then(data => {
                stocksData = data;
                updateAssetPrice();
            })
            .catch(error => console.error('Error fetching stock data:', error));

        // Fetch forex data
        fetch('https://tradededpro.com/app/assets/global/jsons/forex.json')
            .then(response => response.json())
            .then(data => {
                forexData = Object.entries(data.usd).map(([symbol, rate]) => ({
                    symbol: symbol.toUpperCase(),
                    name: symbol.toUpperCase(),
                    rate: rate
                }));
                updateAssetPrice();
            })
            .catch(error => console.error('Error fetching forex data:', error));

        // Function to update asset price
        function updateAssetPrice() {
            const symbol = selectedSymbol.textContent;
            const type = assetType.value;

            if (type === 'Crypto') {
                fetch(`https://min-api.cryptocompare.com/data/price?fsym=${symbol}&tsyms=USD`)
                    .then(response => response.json())
                    .then(data => {
                        const price = data.USD;
                        if (price) {
                            currentAssetPrice.textContent = `$${price.toFixed(2)}`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching crypto price:', error);
                        currentAssetPrice.textContent = '$0.00';
                    });
            } else if (type === 'Stocks') {
                const stock = stocksData.find(s => s.symbol === symbol);
                if (stock && stock.price) {
                    currentAssetPrice.textContent = `$${stock.price.toFixed(2)}`;
                } else {
                    currentAssetPrice.textContent = '$0.00';
                }
            } else if (type === 'Forex') {
                const forex = forexData.find(f => f.symbol === symbol);
                if (forex && forex.rate) {
                    currentAssetPrice.textContent = `$${forex.rate.toFixed(4)}`;
                } else {
                    currentAssetPrice.textContent = '$0.00';
                }
            }
        }

        // Function to populate asset list based on selected type
        function populateAssetList(type) {
            assetList.innerHTML = ''; // Clear existing list

            let assets = [];
            let iconBaseUrl = '';

            if (type === 'Crypto') {
                assets = @json($assets);
                iconBaseUrl = 'https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/';
            } else if (type === 'Stocks') {
                assets = stocksData;
            } else if (type === 'Forex') {
                assets = forexData;
            }

            assets.forEach(asset => {
                let iconSrc = '';
                if (type === 'Crypto') {
                    const symbollowcase = asset.symbol.toLowerCase();
                    iconSrc = iconBaseUrl + symbollowcase + '.svg';
                } else if (type === 'Stocks') {
                    iconSrc = asset.logoUrl;
                } else if (type === 'Forex') {
                    iconSrc = `https://flagcdn.com/36x27/${asset.symbol.substring(0, 2).toLowerCase()}.png`;
                }

                const listItem = document.createElement('li');
                listItem.classList.add('asset-item', 'flex', 'items-center', 'justify-between', 'px-4', 'py-2', 'hover:bg-gray-100', 'cursor-pointer');
                listItem.setAttribute('data-symbol', asset.symbol);
                listItem.setAttribute('data-name', asset.symbol);
                listItem.setAttribute('data-icon', iconSrc);

                listItem.innerHTML = `
                    <div class="flex items-center space-x-2">
                        <img src="${iconSrc}" alt="${asset.symbol}" class="w-4 h-4" onerror="this.onerror=null; this.src='https://cdn-icons-png.flaticon.com/512/0/381.png'">
                        <span class="text-gray-700">${asset.symbol.toUpperCase()}</span>
                    </div>
                    <span class="text-gray-500 text-xs">${type}</span>
                `;
                assetList.appendChild(listItem);

                // Add click listener to asset item
                listItem.addEventListener("click", () => {
                    const symbol = listItem.getAttribute("data-symbol");
                    const name = listItem.getAttribute("data-name");
                    const icon = listItem.getAttribute("data-icon");

                    // Update dropdown button
                    selectedIcon.src = icon;
                    selectedSymbol.textContent = symbol;
                    selectedAssetSymbol.value = symbol;

                    // Update asset price
                    updateAssetPrice();

                    // Close dropdown
                    dropdownMenu.classList.add("hidden");
                });
            });
        }

        // Initial population of asset list
        populateAssetList(assetType.value);

        // Repopulate asset list on asset type change
        assetType.addEventListener('change', (event) => {
            populateAssetList(event.target.value);
            updateAssetPrice();
        });

        // Toggle dropdown
        dropdownButton.addEventListener("click", () => {
            dropdownMenu.classList.toggle("hidden");
            if (!dropdownMenu.classList.contains('hidden')) {
                assetSearch.focus();
            }
        });
     
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });

        // Search functionality
        assetSearch.addEventListener("input", function(e) {
            const query = e.target.value.toLowerCase();
            document.querySelectorAll(".asset-item").forEach((item) => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) ? "flex" : "none";
            });
        });

        // Update signal strength periodically
        function updateSignalStrength(strength) {
            const bars = document.querySelectorAll('.signal-bar');
            const activeCount = Math.ceil((strength / 100) * bars.length);
            
            bars.forEach((bar, index) => {
                if (index < activeCount) {
                    if (index < 1) {
                        bar.style.backgroundColor = 'var(--danger)';
                    } else if (index < 3) {
                        bar.style.backgroundColor = 'var(--warning)';
                    } else {
                        bar.style.backgroundColor = 'var(--success)';
                    }
                    bar.classList.remove('bg-gray-200');
                } else {
                    bar.style.backgroundColor = '';
                    bar.classList.add('bg-gray-200');
                }
            });
            
            const strengthDisplay = document.querySelector('.signal-strength-value');
            strengthDisplay.textContent = `${strength}%`;
            strengthDisplay.classList.toggle('text-success', strength > 50);
            strengthDisplay.classList.toggle('text-danger', strength <= 50);
        }

        // Example: Update signal strength every 5 seconds with random value
        setInterval(() => {
            const newStrength = Math.floor(Math.random() * 100);
            updateSignalStrength(newStrength);
        }, 5000);
    });

    // Form submission with validation
    document.getElementById('tradeForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitButton = document.getElementById('submitTrade');
        const originalButtonText = submitButton.textContent;
        
        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="ri-loader-4-line animate-spin mr-1"></i> Processing...';
        
        // Perform form validation
        const amount = parseFloat(form.amount.value);
        const balance = parseFloat("{{ auth()->user()->balance }}");
        
        if (isNaN(amount) || amount <= 0) {
            alert('Please enter a valid amount');
            submitButton.disabled = false;
            submitButton.textContent = originalButtonText;
            return;
        }
        
        if (amount > balance) {
            alert('Insufficient balance for this trade');
            submitButton.disabled = false;
            submitButton.textContent = originalButtonText;
            return;
        }
        
        // If validation passes, submit the form
        form.submit();
    });
</script>
@endsection