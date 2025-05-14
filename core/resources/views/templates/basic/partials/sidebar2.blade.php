<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Desktop Sidebar -->
<aside class="hidden lg:block lg:fixed lg:inset-y-0 lg:left-0 lg:z-50 lg:w-64 lg:overflow-y-auto border-r border-gray-100 bg-white shadow-sm">
    <!-- Logo / Title -->
    <div class="p-4 mb-2 flex items-center justify-between">
        <a href="#" class="text-2xl font-bold text-gray-900 flex items-center gap-2">
            <img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="Logo" class="h-8 w-auto">
            <span>Volttraders</span>
        </a>
    </div>
    
    <!-- User Section -->
    <div class="px-4 py-3 border-b border-gray-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                {{ substr(auth()->user()->username, 0, 1) }}
            </div>
            <div>
                <div class="text-sm font-medium text-gray-900">{{ auth()->user()->username }}</div>
                <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
            </div>
        </div>
    </div>
    
    <!-- Navigation -->
    <nav class="p-4 space-y-1">
        <!-- Main Navigation Group -->
        <div class="pb-2">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 pl-2">Main</div>
            <a href="{{ route('user.home') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('user.home') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-dashboard-line text-lg"></i> 
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('user.assets.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('user.assets.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-coin-line text-lg"></i> 
                <span>Assets</span>
            </a>
            
            <a href="{{ route('market.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('market.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-line-chart-line text-lg"></i> 
                <span>Markets</span>
            </a>
            
            <a href="{{ route('trade.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('trade.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-exchange-box-line text-lg"></i> 
                <span>Trade</span>
            </a>  
        </div>
        
        <!-- Finance Group -->
        <div class="pb-2 pt-2 border-t border-gray-100">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 pl-2">Finance</div>
            <a href="{{ route('crypto.deposit.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('crypto.deposit.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-arrow-right-circle-line text-lg"></i> 
                <span>Deposit</span>
            </a>
            
            <a href="{{ route('user.withdraw') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('user.withdraw') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-arrow-left-circle-line text-lg"></i> 
                <span>Withdraw</span>
            </a>
            
            <a href="{{ route('user.wallet.list') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('user.wallet.list') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-wallet-3-line text-lg"></i> 
                <span>Wallet</span>
            </a>
        </div>
        
        <!-- Trading Services -->
        <div class="pb-2 pt-2 border-t border-gray-100">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 pl-2">Services</div>
            
            <a href="{{ route('subscribers.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('subscribers.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-radio-line text-lg"></i> 
                <span>Subscribe</span>
            </a>
            
            <a href="{{ route('user.signals.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('user.signals.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-signal-tower-line text-lg"></i> 
                <span>Signals</span>
            </a>
            
            <a href="{{ route('staking.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('staking.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-money-dollar-circle-line text-lg"></i> 
                <span>Stake</span>
            </a>
            
            <a href="#" onclick="walletNotAvailable()" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-gray-700 hover:bg-gray-50 transition-all">
                <i class="ri-wallet-3-line text-lg"></i> 
                <span>Connect wallet</span>
            </a>
            
            <a href="{{ route('copy.expert.index') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('copy.expert.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-user-follow-line text-lg"></i> 
                <span>Copy Experts</span>
            </a>
        </div>
        
        <!-- Account -->
        <div class="pb-2 pt-2 border-t border-gray-100 mt-auto">
            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 pl-2">Account</div>
            
            <a href="{{ route('user.profile.setting') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 {{ request()->routeIs('user.profile.setting') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }} transition-all">
                <i class="ri-settings-3-line text-lg"></i> 
                <span>Settings</span>
            </a>
            
            <a href="{{ route('user.logout') }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-red-600 hover:bg-red-50 transition-all">
                <i class="ri-logout-circle-line text-lg"></i> 
                <span>Logout</span>
            </a>
        </div>
    </nav>
</aside>

<!-- Mobile Navigation - Simple Version -->
<div x-data="{ mobileMenuOpen: false }" class="lg:hidden">
    <!-- Mobile Top Bar -->
    <div class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-gray-200 px-4 py-2">
        <div class="flex items-center justify-between">
            <a href="#" class="font-bold text-gray-900 flex items-center gap-2">
                <img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="Logo" class="h-8 w-auto">
                <span>Volttraders</span>
            </a>
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-500 hover:text-indigo-600 p-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" 
         @click.away="mobileMenuOpen = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-x-full"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform -translate-x-full"
         class="fixed inset-0 z-50 bg-gray-900 bg-opacity-30" style="display: none;">
        
        <div class="absolute top-0 left-0 bottom-0 w-3/4 max-w-sm bg-white shadow-xl overflow-y-auto">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <a href="#" class="font-bold text-gray-900">Volttraders</a>
                <button @click="mobileMenuOpen = false" class="text-gray-500 hover:text-indigo-600 p-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-4">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold">
                        {{ substr(auth()->user()->username, 0, 1) }}
                    </div>
                    <div>
                        <div class="text-sm font-medium text-gray-900">{{ auth()->user()->username }}</div>
                        <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                
                <nav class="space-y-4">
                    <!-- Main Section -->
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Main</div>
                    
                    <a href="{{ route('user.home') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('user.home') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-dashboard-line text-lg"></i> Dashboard
                        </div>
                    </a>
                    
                    <a href="{{ route('user.assets.index') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('user.assets.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-coin-line text-lg"></i> Assets
                        </div>
                    </a>
                    
                    <a href="{{ route('market.index') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('market.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-line-chart-line text-lg"></i> Markets
                        </div>
                    </a>
                    
                    <a href="{{ route('trade.index') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('trade.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-exchange-box-line text-lg"></i> Trade
                        </div>
                    </a>
                    
                    <!-- Finance Section -->
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Finance</div>
                    
                    <a href="{{ route('crypto.deposit.index') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('crypto.deposit.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-arrow-right-circle-line text-lg"></i> Deposit
                        </div>
                    </a>
                    
                    <a href="{{ route('user.withdraw') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('user.withdraw') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-arrow-left-circle-line text-lg"></i> Withdraw
                        </div>
                    </a>
                    
                    <a href="{{ route('user.wallet.list') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('user.wallet.list') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-wallet-3-line text-lg"></i> Wallet
                        </div>
                    </a>
                    
                    <!-- Services Section -->
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Services</div>
                    
                    <a href="{{ route('subscribers.index') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('subscribers.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-radio-line text-lg"></i> Subscribe
                        </div>
                    </a>
                    
                    <a href="{{ route('user.signals.index') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('user.signals.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-signal-tower-line text-lg"></i> Signals
                        </div>
                    </a>
                    
                    <a href="{{ route('staking.index') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('staking.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-money-dollar-circle-line text-lg"></i> Stake
                        </div>
                    </a>
                    
                    <a href="#" onclick="walletNotAvailable(); mobileMenuOpen = false;" class="block rounded-lg px-4 py-2.5 text-gray-700 hover:bg-gray-50">
                        <div class="flex items-center gap-3">
                            <i class="ri-wallet-3-line text-lg"></i> Connect Wallet
                        </div>
                    </a>
                    
                    <a href="{{ route('copy.expert.index') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('copy.expert.index') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-user-follow-line text-lg"></i> Copy Experts
                        </div>
                    </a>
                    
                    <!-- Account Section -->
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mt-6 mb-2">Account</div>
                    
                    <a href="{{ route('user.profile.setting') }}" class="block rounded-lg px-4 py-2.5 {{ request()->routeIs('user.profile.setting') ? 'bg-indigo-50 text-indigo-700 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-gray-50' }}">
                        <div class="flex items-center gap-3">
                            <i class="ri-settings-3-line text-lg"></i> Settings
                        </div>
                    </a>
                    
                    <a href="{{ route('user.logout') }}" class="block rounded-lg px-4 py-2.5 text-red-600 hover:bg-red-50">
                        <div class="flex items-center gap-3">
                            <i class="ri-logout-circle-line text-lg"></i> Logout
                        </div>
                    </a>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Add padding to main content for mobile header -->
    <div class="h-14"></div>
</div>

<script>
    function walletNotAvailable() {
        Swal.fire({
            icon: 'warning',
            title: 'Wallet Not Available',
            text: 'The wallet feature is currently not available. Please try again later.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4f46e5'
        });
    }
</script>