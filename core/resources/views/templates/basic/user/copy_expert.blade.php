@extends($activeTemplate . 'layouts.master2')

@section('content')
<main class="p-4 sm:px-6 flex-1 overflow-auto bg-gray-50 text-gray-900">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Copy Trading Experts</h1>
        <p class="text-gray-600 mt-1">Follow top-performing traders and automatically copy their trades</p>
    </div>
    
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Top Expert Win Rate</p>
                    <p class="text-xl font-bold text-green-600">94.7%</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Active Copiers</p>
                    <p class="text-xl font-bold text-blue-600">1,254</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Monthly Returns</p>
                    <p class="text-xl font-bold text-indigo-600">+23.4%</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter/Search section -->
    <div class="flex flex-col sm:flex-row gap-4 justify-between mb-6">
        <div class="flex items-center gap-4">
            <div class="bg-white rounded-lg border border-gray-200 flex items-center px-3 py-2 w-64">
                <svg class="h-5 w-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search experts" class="border-none focus:ring-0 p-0 w-full text-sm bg-transparent">
            </div>
            
            <select class="bg-white border border-gray-200 text-gray-700 py-2 px-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                <option value="all">All Assets</option>
                <option value="crypto">Crypto</option>
                <option value="forex">Forex</option>
                <option value="stocks">Stocks</option>
            </select>
        </div>
        
        <div class="flex gap-2">
            <button class="px-4 py-2 border border-gray-200 rounded-lg text-gray-600 bg-white hover:bg-gray-50 text-sm font-medium">Most Popular</button>
            <button class="px-4 py-2 border border-gray-200 rounded-lg text-gray-600 bg-white hover:bg-gray-50 text-sm font-medium">Highest Returns</button>
        </div>
    </div>

    <!-- Experts Grid - With blur effect if feature is locked -->
    {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 @if(optional($getCopyExpertFee->first())->type != 'expert_fee') filter blur-[3px] pointer-events-none select-none @endif">   --}}
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($copy_experts as $expert)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
                <!-- Expert Header -->
                <div class="relative">
                    <div class="h-28 bg-gradient-to-r from-indigo-500 to-blue-500"></div>
                    <div class="absolute -bottom-10 left-6">
                        <div class="rounded-full h-20 w-20 bg-white p-1 shadow-md">
                            <img 
                                class="h-full w-full object-cover rounded-full" 
                                src="https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg?semt=ais_hybrid&w=740" 
                                alt="{{ $expert->name }}">
                            {{-- > <img 
                                class="h-full w-full object-cover rounded-full" 
                                src="{{ $expert->image ? asset('storage/app/' . $expert->image) : 'https://ui-avatars.com/api/?name='.urlencode($expert->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                alt="{{ $expert->name }}"
                            > --}}
                        </div>
                    </div>
                    <div class="absolute top-4 right-4 bg-white bg-opacity-90 rounded-full px-3 py-1 text-xs font-semibold text-indigo-700">
                        {{ number_format((float)$expert->win_rate, 1) }}% Win Rate
                    </div>
                </div>
                
                <!-- Expert Content -->
                <div class="pt-12 pb-4 px-6">
                    <h3 class="text-lg font-bold text-gray-900">{{ $expert->name }}</h3>
                    <p class="text-gray-500 text-sm mb-4">Professional Trader • {{ rand(2, 8) }} years experience</p>
                    
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 p-3 rounded-lg text-center">
                            <p class="text-xs text-gray-500 mb-1">Profit</p>
                            <p class="text-indigo-600 font-bold">${{ number_format((float)$expert->profit, 2) }}</p>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg text-center">
                            <p class="text-xs text-gray-500 mb-1">Win/Loss</p>
                            <p class="text-indigo-600 font-bold">{{ (int)$expert->wins }}/{{ (int)$expert->loss }}</p>
                        </div>
                    </div>
                    
                    <!-- Performance Chart - Placeholder -->
                    <div class="h-16 mb-4 bg-gray-50 rounded-lg overflow-hidden relative">
                        <div class="absolute inset-0 flex items-center justify-center text-xs text-gray-400">Performance Chart</div>
                        <svg class="w-full h-full" viewBox="0 0 100 20" preserveAspectRatio="none">
                            <path 
                                d="M0,10 L5,12 L10,8 L15,14 L20,11 L25,16 L30,10 L35,8 L40,16 L45,14 L50,6 L55,12 L60,10 L65,14 L70,12 L75,8 L80,10 L85,6 L90,8 L95,4 L100,6" 
                                fill="none" 
                                stroke="#6366F1" 
                                stroke-width="2"
                            />
                        </svg>
                    </div>
                    
                    <!-- CTA -->
                    <form action="{{ route('copy.expert.storeCopy') }}" method="POST">
                        @csrf
                        <input type="hidden" name="expert_id" value="{{ $expert->id }}">
                        <button class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            Copy Expert
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Unlock Modal -->
    <div id="depositModal" class="fixed inset-0 bg-black bg-opacity-70 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 relative overflow-hidden">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Unlock Copy Trading</h2>
                <div class="flex items-center gap-3">
                    <a href="{{ route('user.home') }}" class="text-gray-500 hover:text-gray-700 text-sm">
                        Back to home
                    </a>
                    <button id="closeModalButton" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Accent Line -->
            <div class="h-1 w-24 bg-indigo-600 rounded mb-6"></div>
            
            <!-- Modal Content -->
            <div class="space-y-6">
                <div class="bg-indigo-50 rounded-lg p-4 border border-indigo-100">
                    <div class="flex items-start gap-3">
                        <div class="bg-indigo-100 p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-medium text-indigo-900">Copy Trading Feature Locked</h3>
                            <p class="text-sm text-indigo-700">To unlock this premium feature, a one-time payment of 0.051 BTC is required.</p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('user.crypto.deposit.store') }}" method="POST" enctype="multipart/form-data" id="depositForm">
                    @csrf
                    <input type="hidden" name="type" value="expert_fee">
                    <input type="hidden" name="amount" value="0.051">
                    
                    <div class="space-y-4">
                        <!-- Payment method selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                            <select class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-gray-800 appearance-none focus:outline-none focus:ring-2 focus:ring-indigo-500" name="currency" required>
                                <option value="BTC" selected>Bitcoin (BTC)</option>
                            </select>
                        </div>
                        
                        <!-- QR code -->
                        <div class="flex justify-center bg-white p-4 rounded-lg border border-gray-200">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?data=bc1q8x5q8kcgchzs55su83ue96kzjxdh7l7nrk25ya&size=150x150" alt="Bitcoin QR Code" class="h-36 w-36">
                        </div>

                        <!-- Wallet address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deposit Address</label>
                            <div class="flex gap-2">
                                <input type="text" readonly class="w-full bg-gray-50 border border-gray-300 rounded-lg px-3 py-2 text-sm text-gray-800" value="bc1q8x5q8kcgchzs55su83ue96kzjxdh7l7nrk25ya">
                                <button type="button" id="copyAddressButton" class="bg-gray-100 hover:bg-gray-200 p-2 rounded-lg text-gray-600 tooltip transition-colors" data-tooltip="Copy Address">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/>
                                        <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Payment proof upload -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Payment Proof</label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-indigo-500 transition-colors">
                                <input type="file" name="proof" accept="image/*" required class="hidden" id="proofUpload">
                                <label for="proofUpload" class="cursor-pointer flex flex-col items-center justify-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-sm text-gray-500">Click to select payment screenshot</span>
                                </label>
                            </div>
                        </div>

                        <!-- Submit button -->
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg py-3 transition-colors font-medium">
                            Submit Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const depositModal = document.getElementById('depositModal');
            const closeModalButton = document.getElementById('closeModalButton');
            const copyAddressButton = document.getElementById('copyAddressButton');
            const walletAddress = "bc1q8x5q8kcgchzs55su83ue96kzjxdh7l7nrk25ya";
            
            // File input preview
            const proofUpload = document.getElementById('proofUpload');
            proofUpload?.addEventListener('change', function(e) {
                const parent = this.parentElement;
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    parent.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span class="text-sm text-gray-700 font-medium">${fileName}</span>
                        <span class="text-xs text-gray-500">File selected</span>
                    `;
                }
            });
            
            // Copy wallet address
            copyAddressButton?.addEventListener('click', function() {
                navigator.clipboard.writeText(walletAddress).then(() => {
                    const originalInnerHTML = this.innerHTML;
                    this.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    `;
                    setTimeout(() => {
                        this.innerHTML = originalInnerHTML;
                    }, 2000);
                });
            });

            @if(optional($getCopyExpertFee->first())->type != 'expert_fee')
                // Show the modal automatically
                depositModal.style.display = 'none';
            @else
                // Hide the modal
                depositModal.style.display = 'none';
            @endif

            // Close the modal when the close button is clicked
            closeModalButton?.addEventListener('click', function() {
                depositModal.style.display = 'none';
            });
        });
    </script>
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
        z-index: 10;
    }

    .tooltip:hover:before {
        opacity: 1;
        visibility: visible;
    }
    
    /* Add smooth blur animation to draw attention */
    .blur-subtle {
        animation: blur-pulse 2s infinite alternate;
    }
    
    @keyframes blur-pulse {
        0% {
            filter: blur(3px);
        }
        100% {
            filter: blur(5px);
        }
    }
</style>
@endpush

@push('script')
<script>
    // ...existing code...
</script>
@endpush
@endsection