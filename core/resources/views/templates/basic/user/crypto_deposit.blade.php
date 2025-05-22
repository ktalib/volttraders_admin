@extends($activeTemplate . 'layouts.master2')

@section('content')
<main class="p-4 sm:px-6 flex-1 overflow-auto bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-42 gap-6">
        <!-- Deposits Section -->
        <div class="p-6 bg-white rounded-xl shadow-md">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">Deposits</h1>
                <button onclick="openModal()" class="bg-gradient-to-r from-indigo-600 to-blue-500 hover:from-indigo-700 hover:to-blue-600 px-5 py-2.5 rounded-lg text-white font-medium shadow-md transition-all">
                    Deposit now
                </button>
            </div>

            <!-- Responsive Table -->
            <div class="w-full overflow-x-auto rounded-lg border border-gray-100">
                <table class="min-w-full text-sm text-left text-black">
                    <thead class="bg-gray-50 text-gray-600 font-medium">
                        <tr>
                            <th class="px-4 py-3">Date</th>
                            <th class="px-4 py-3">Reference</th>
                            <th class="px-4 py-3">Method</th>
                            <th class="px-4 py-3">Type</th>
                            <th class="px-4 py-3">Amount</th>
                            <th class="px-4 py-3">In (USD)</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($cryptoDeposits as $deposit)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-black">{{ $deposit->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-3 text-black">{{ $deposit->reference }}</td>
                                <td class="px-4 py-3 text-black">{{ $deposit->currency }}</td>
                                <td class="px-4 py-3 text-black">{{ $deposit->type }}</td>
                                <td class="px-4 py-3 text-black">{{ number_format($deposit->amount, 2) }}</td>
                                <td class="px-4 py-3 text-black" id="usd-amount-{{ $deposit->id }}"></td>
                                <td class="px-4 py-3 text-black">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium
                                        @if($deposit->status == 1) bg-green-100 text-green-800
                                        @elseif($deposit->status == 2) bg-amber-100 text-amber-800
                                        @elseif($deposit->status == 3) bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        @if($deposit->status == 0) Initiated
                                        @elseif($deposit->status == 1) Completed
                                        @elseif($deposit->status == 2) Pending
                                        @elseif($deposit->status == 3) Rejected
                                        @else Pending
                                        @endif
                                    </span>
                                </td>
                            </tr>
                            <script>
                                fetch(`https://min-api.cryptocompare.com/data/price?fsym={{ $deposit->currency }}&tsyms=USD&api_key=6994a7265d2d0ad7b35a3de4ff877b7c54d8e922f7c7c05141a4583ed300fcfd`)
                                    .then(response => response.json())
                                    .then(data => {
                                        const usdAmount = ({{ $deposit->amount }} * data.USD).toFixed(2);
                                        document.getElementById('usd-amount-{{ $deposit->id }}').textContent = `$${usdAmount}`;
                                    })
                                    .catch(error => console.error('Error fetching USD conversion:', error));
                            </script>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-500">
                                    You have not made any deposits yet.
                                    <button onclick="openModal()" class="text-indigo-600 hover:text-indigo-800 hover:underline ml-1 font-medium">
                                        Click here to make a deposit.
                                    </button>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Deposit Modal -->
    <div id="depositModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Deposit</h2>
                <button id="closeModalButton" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <p class="text-gray-600 text-sm mb-6">
                Choose method, enter amount and upload payment proof to proceed.
            </p>

            <form action="{{ route('user.crypto.deposit.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="crypto">

                <div class="space-y-4">
                    <!-- Method -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Method:</label>
                        <select name="currency" id="cryptoMethod" class="w-full bg-white text-black border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-indigo-100 focus:border-indigo-500" required>
                            @foreach($gateways as $currency)
                                <option 
                                    value="{{ $currency->name }}"
                                    data-wallet="{{ $currency->description }}"
                                    data-icon="https://raw.githubusercontent.com/spothq/cryptocurrency-icons/refs/heads/master/svg/color/{{ strtolower($currency->name) }}.svg"
                                >
                                    {{ $currency->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Wallet -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address:</label>
                        <div class="flex items-center space-x-2">
                            <input type="text" id="walletAddress" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2 text-sm text-black" readonly>
                            <button type="button" id="copyAddressButton" class="text-gray-400 hover:text-indigo-600 transition">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z"/>
                                    <path d="M6 3a2 2 0 00-2 2v11a2 2 0 002 2h8a2 2 0 002-2V5a2 2 0 00-2-2 3 3 0 01-3 3H9a3 3 0 01-3-3z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Amount -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Amount:</label>
                        <div class="flex items-center">
                            <input type="text" name="amount" value="0.00" required class="w-full bg-gray-50 border border-gray-200 rounded-l-lg px-4 py-2 text-gray-700 text-black">
                            <span id="cryptoIcon" class="bg-gray-100 border border-gray-200 rounded-r-lg px-4 py-2 text-gray-700 min-w-[70px] flex items-center justify-center"></span>
                        </div>
                    </div>

                    <!-- Payment Proof -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Proof:</label>
                        <input type="file" name="proof" required class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-2">
                    </div>

                    <!-- Submit -->
                    <div class="pt-2">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-lg font-medium transition">
                            Submit Deposit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    // Toggle Modal
    function openModal() {
        document.getElementById('depositModal').classList.remove('hidden');
    }

    document.getElementById('closeModalButton')?.addEventListener('click', () => {
        document.getElementById('depositModal').classList.add('hidden');
    });

    // Update Wallet Address and Crypto Icon
    document.getElementById('cryptoMethod')?.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        
        // Update wallet address
        const walletAddress = selectedOption.getAttribute('data-wallet');
        document.getElementById('walletAddress').value = walletAddress || '';
        
        // Update crypto icon
        const iconUrl = selectedOption.getAttribute('data-icon');
        const cryptoIcon = document.getElementById('cryptoIcon');
        if (cryptoIcon && iconUrl) {
            cryptoIcon.innerHTML = `<img src="${iconUrl}" alt="${selectedOption.value}" class="h-5 w-5">`;
        } else {
            cryptoIcon.textContent = selectedOption.value;
        }
    });

    // Copy wallet address to clipboard
    document.getElementById('copyAddressButton')?.addEventListener('click', function() {
        const walletAddress = document.getElementById('walletAddress');
        
        if (walletAddress.value) {
            // Select the text
            walletAddress.select();
            walletAddress.setSelectionRange(0, 99999); // For mobile devices
            
            // Copy to clipboard
            navigator.clipboard.writeText(walletAddress.value)
                .then(() => {
                    // Provide visual feedback
                    const originalColor = this.classList.contains('text-indigo-600') ? 'text-indigo-600' : 'text-gray-400';
                    this.classList.remove(originalColor);
                    this.classList.add('text-green-500');
                    
                    // Change back after a short delay
                    setTimeout(() => {
                        this.classList.remove('text-green-500');
                        this.classList.add(originalColor);
                    }, 1000);
                })
                .catch(err => {
                    console.error('Failed to copy: ', err);
                });
        }
    });

    // Set initial wallet address on page load
    window.addEventListener('DOMContentLoaded', function() {
        const cryptoMethod = document.getElementById('cryptoMethod');
        if (cryptoMethod) {
            const selectedOption = cryptoMethod.options[cryptoMethod.selectedIndex];
            const walletAddress = selectedOption.getAttribute('data-wallet');
            document.getElementById('walletAddress').value = walletAddress || '';
            
            // Also set initial crypto icon
            const iconUrl = selectedOption.getAttribute('data-icon');
            const cryptoIcon = document.getElementById('cryptoIcon');
            if (cryptoIcon && iconUrl) {
                cryptoIcon.innerHTML = `<img src="${iconUrl}" alt="${selectedOption.value}" class="h-5 w-5">`;
            } else {
                cryptoIcon.textContent = selectedOption.value;
            }
        }
    });
</script>
@endsection
