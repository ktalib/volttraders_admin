@extends($activeTemplate . 'layouts.master2')

@section('content')
<main class="p-4 sm:p-6 flex-1 overflow-auto bg-gray-50 text-gray-900">
    <div class="max-w-7xl mx-auto">
        <!-- Market Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Market Overview</h1>
                <p class="text-sm text-gray-500 mt-1">Track real-time prices and market data</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="text-sm bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                    <span class="text-gray-500">Last updated:</span> 
                    <span id="lastUpdated" class="text-gray-800 font-medium"></span>
                </div>
                <button id="refreshData" class="bg-white p-2 rounded-lg shadow-sm border border-gray-200 text-blue-600 hover:bg-blue-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Market Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Bitcoin</span>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-medium">+1.2%</span>
                </div>
                <div class="mt-2">
                    <div class="text-xl font-bold">$37,245.80</div>
                    <div class="flex items-center text-xs text-green-600 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        $420.45 today
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Ethereum</span>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-medium">+3.4%</span>
                </div>
                <div class="mt-2">
                    <div class="text-xl font-bold">$2,145.70</div>
                    <div class="flex items-center text-xs text-green-600 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        $71.20 today
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">Euro</span>
                    <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full font-medium">-0.5%</span>
                </div>
                <div class="mt-2">
                    <div class="text-xl font-bold">$0.9324</div>
                    <div class="flex items-center text-xs text-red-600 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        $0.0046 today
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-500">S&P 500</span>
                    <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-medium">+0.8%</span>
                </div>
                <div class="mt-2">
                    <div class="text-xl font-bold">$4,890.25</div>
                    <div class="flex items-center text-xs text-green-600 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        $39.12 today
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 w-full">
                    <div>
                        <label for="assetType" class="block text-sm font-medium text-gray-700 mb-1">Asset Type</label>
                        <select id="assetType" class="bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 w-full focus:ring-blue-500 focus:border-blue-500 appearance-none">
                            <option value="all">All Assets</option>
                            <option value="crypto">Cryptocurrencies</option>
                            <option value="fiat">Fiat Currencies</option>
                            <option value="stock">Stocks</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="sortBy" class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                        <select id="sortBy" class="bg-gray-50 border border-gray-200 text-gray-800 rounded-lg px-4 py-2.5 w-full focus:ring-blue-500 focus:border-blue-500 appearance-none">
                            <option value="name">Name (A-Z)</option>
                            <option value="name_desc">Name (Z-A)</option>
                            <option value="price">Price (Low-High)</option>
                            <option value="price_desc">Price (High-Low)</option>
                            <option value="change">24h Change (Low-High)</option>
                            <option value="change_desc">24h Change (High-Low)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="searchAsset" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <div class="relative">
                            <input type="text" id="searchAsset" placeholder="Search assets..." class="bg-gray-50 border border-gray-200 text-gray-800 rounded-lg pl-10 pr-4 py-2.5 w-full focus:ring-blue-500 focus:border-blue-500">
                            <svg class="w-5 h-5 absolute left-3 top-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assets Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Asset</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Price (USD)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">24h Change</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Market Cap</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Volume (24h)</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody id="assetsTableBody" class="bg-white divide-y divide-gray-100">
                        <!-- Loading state -->
                        <tr id="loadingRow">
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                <div class="flex justify-center items-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span class="text-sm">Loading market data...</span>
                                </div>
                            </td>
                        </tr>
                        <!-- Error state (hidden by default) -->
                        <tr id="errorRow" class="hidden">
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="max-w-md mx-auto">
                                    <svg class="h-12 w-12 text-red-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <p class="text-red-500 font-medium">Failed to load market data</p>
                                    <p class="text-gray-500 text-sm mt-1">Please check your internet connection and try again.</p>
                                    <button id="retryButton" class="mt-3 bg-red-100 text-red-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors">
                                        Retry
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Empty state (hidden by default) -->
                        <tr id="emptyRow" class="hidden">
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="max-w-md mx-auto">
                                    <svg class="h-12 w-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-gray-700 font-medium">No assets found</p>
                                    <p class="text-gray-500 text-sm mt-1">Try changing your search criteria.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="bg-gray-50 px-6 py-4 flex items-center justify-between border-t border-gray-200">
                <div class="flex-1 flex justify-between sm:hidden">
                    <a href="#" id="prevPageMobile" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Previous
                    </a>
                    <a href="#" id="nextPageMobile" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next
                    </a>
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing <span id="paginationFrom" class="font-medium">1</span> to <span id="paginationTo" class="font-medium">10</span> of <span id="paginationTotal" class="font-medium">100</span> results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#" id="prevPage" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="sr-only">Previous</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <div id="paginationNumbers" class="flex">
                                <!-- Page numbers will be inserted here -->
                            </div>
                            <a href="#" id="nextPage" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="sr-only">Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
@include($activeTemplate . 'user.market_js')
@endpush