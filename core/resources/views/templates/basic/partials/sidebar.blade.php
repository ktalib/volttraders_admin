<ul class="sidebar-menu-list space-y-2">
    <li class="mb-4">
        <a href="{{ route('trade') }}" class="w-full flex items-center justify-center py-3 px-4 rounded-lg bg-gradient-to-r from-indigo-600 to-blue-500 text-white font-medium shadow-md hover:shadow-lg transition-all hover:from-indigo-700 hover:to-blue-600">
            New Challenge
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.home') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive('user.home') }}">
            <span class="icon text-indigo-600"><i class="fas fa-home"></i></span>
            <span class="text font-medium">@lang('Dashboard')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.plan.progress') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive('user.plan.progress') }}">
            <span class="icon text-indigo-600"><i class="fas fa-chart-line"></i></span>
            <span class="text font-medium">@lang('Progress')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.order.history') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive('user.order*') }}">
            <span class="icon text-indigo-600"><i class="fas fa-cubes"></i></span>
            <span class="text font-medium">@lang('Manage Order')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.trade.history') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive('user.trade.history') }}">
            <span class="icon text-indigo-600"><i class="fas fa-chart-bar"></i></span>
            <span class="text font-medium">@lang('Trade History')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.plan.history') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive(['user.plan.history', 'user.plan.list']) }}">
            <span class="icon text-indigo-600"><i class="fas fa-cube"></i></span>
            <span class="text font-medium">@lang('Plan History')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.wallet.list') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive('user.wallet*') }}">
            <span class="icon text-indigo-600"><i class="fas fa-wallet"></i></span>
            <span class="text font-medium">@lang('Manage Wallet')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.deposit.history') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive('user.deposit.history') }}">
            <span class="icon text-indigo-600"><i class="fas fa-credit-card"></i></span>
            <span class="text font-medium">@lang('Payment History')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.withdraw.history') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive('user.withdraw.history') }}">
            <span class="icon text-indigo-600"><i class="fas fa-hand-holding-usd"></i></span>
            <span class="text font-medium">@lang('Withdraw History')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.transactions') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive('user.transactions') }}">
            <span class="icon text-indigo-600"><i class="fa fa-exchange-alt"></i></span>
            <span class="text font-medium">@lang('Transaction')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('ticket.index') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive('ticket*') }}">
            <span class="icon text-indigo-600"><i class="fas fa-headset"></i></span>
            <span class="text font-medium">@lang('Support Ticket')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.twofactor') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-all {{ menuActive('user.twofactor') }}">
            <span class="icon text-indigo-600"><i class="fas fa-shield-alt"></i></span>
            <span class="text font-medium">@lang('Security')</span>
        </a>
    </li>

    <li class="sidebar-menu-list__item">
        <hr class="border-gray-200 my-2" />
    </li>

    <li class="sidebar-menu-list__item">
        <a href="{{ route('user.logout') }}" class="sidebar-menu-list__link flex items-center gap-3 py-3 px-4 rounded-lg text-gray-700 hover:bg-red-50 hover:text-red-600 transition-all">
            <span class="icon text-red-500"><i class="fas fa-sign-out-alt"></i></span>
            <span class="text font-medium">@lang('Log Out')</span>
        </a>
    </li>
</ul>