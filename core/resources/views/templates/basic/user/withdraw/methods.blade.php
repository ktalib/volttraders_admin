@extends($activeTemplate . 'layouts.master2')

@section('content')
<main class="p-2 sm:px-2 flex-1 overflow-auto bg-white">
    <div class="grid grid-cols-1 ld:grid-cols-2 gap-12">
        <div class="p-4 rounded-lg  bg-transparent">

            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-xl font-semibold text-white">Withdraw</h1>
                <button  id="openModal"  class="bg-blue-500 hover:bg-blue-600 px-4 py-2 rounded-lg text-white">
                 Withdraw 
                </button>
            </div>

            <!-- Deposits Table -->
            <div class="w-full overflow-x-auto">
             @include($activeTemplate.'user.withdraw.log')
            </div>
            <div
    id="withdrawModal"
    class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm flex items-center justify-center hidden z-50 transition-opacity duration-300"
>
    <div class="bg-white text-gray-800 rounded-xl shadow-2xl p-8 w-full max-w-md relative border border-gray-200 transform transition-all duration-300">
        <!-- Close Button -->
        <button
            id="closeModal"
            class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-full w-8 h-8 flex items-center justify-center transition-colors duration-200"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        <!-- Modal Content -->
        <div class="mb-6">
            <h3 class="text-xl font-bold mb-2 text-blue-600">Withdraw Funds</h3>
            <div class="h-1 w-16 bg-blue-500 rounded mb-4"></div>
            <p class="text-gray-600 text-sm">
                Select your withdrawal method, enter the amount and verify your payment details below.
            </p>
        </div>

        <form action="{{ route('user.withdraw.money') }}" method="post" class="withdraw-form space-y-5">
            @csrf
            <!-- Type Selection -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700" for="type">Withdrawal Method</label>
                <div class="relative">
                    <select
                        id="type"
                        class="appearance-none bg-gray-100 text-gray-800 rounded-lg pl-4 pr-10 py-3 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent border border-gray-200 transition-all duration-200"
                        name="method_code"
                    >
                        @foreach ($withdrawMethod as $data)
                            <option value="{{ $data->id }}" data-gateway='@json($data)'>
                                {{ __($data->name) }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Amount Input -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700" for="amount">Amount</label>
                <div class="flex items-center bg-gray-100 rounded-lg border border-gray-200 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent transition-all duration-200">
                    <input
                        type="number"
                        id="amount"
                        name="amount"
                        placeholder="0.00"
                        class="bg-transparent text-gray-800 rounded-lg px-4 py-3 w-full focus:outline-none"
                        value="{{ old('amount') }}"
                    />
                    <span class="text-gray-700 pr-4 font-medium">{{ gs('cur_sym') }}</span>
                </div>
            </div>

            <!-- Balance Information -->
            <div class="bg-neutral-300 rounded-lg p-4 border border-neutral-400">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Available Balance:</span>
                    <span class="text-md font-medium text-gray-900">{{ showAmount(auth()->user()->balance) }} {{ gs('cur_sym') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Equivalent USD:</span>
                    <span class="text-md font-medium text-gray-900">${{ showAmount(auth()->user()->balance * gs('usd_rate')) }}</span>
                </div>
            </div>

            <!-- Withdraw Button -->
            <button
                class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white py-3 px-4 rounded-lg font-medium transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-lg"
                type="submit"
            >
                Withdraw Funds
            </button>
        </form>
    </div>
</div>

<script>
    const openModalButton = document.getElementById("openModal");
    const closeModalButton = document.getElementById("closeModal");
    const modal = document.getElementById("withdrawModal");

    // Open modal with animation
    openModalButton.addEventListener("click", () => {
        modal.classList.remove("hidden");
        setTimeout(() => {
            modal.querySelector("div").classList.remove("opacity-0", "scale-95");
            modal.querySelector("div").classList.add("opacity-100", "scale-100");
        }, 10);
    });

    // Close modal with animation
    closeModalButton.addEventListener("click", () => {
        modal.querySelector("div").classList.add("opacity-0", "scale-95");
        modal.querySelector("div").classList.remove("opacity-100", "scale-100");
        setTimeout(() => {
            modal.classList.add("hidden");
        }, 300);
    });

    // Close modal when clicking outside
    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            closeModalButton.click();
        }
    });
</script>
          
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
</style>
@endpush

 
<script>
    const openModalButton = document.getElementById("openModal");
    const closeModalButton = document.getElementById("closeModal");
    const modal = document.getElementById("withdrawModal");

    // Open modal
    openModalButton.addEventListener("click", () => {
      modal.classList.remove("hidden");
    });

    // Close modal
    closeModalButton.addEventListener("click", () => {
      modal.classList.add("hidden");
    });

    // Close modal when clicking outside of it
    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.classList.add("hidden");
      }
    });
  </script>
 
@endsection