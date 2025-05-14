@extends('admin.layouts.app')
@section('panel')
    <div class="row justify-content-center">
        @if (request()->routeIs('admin.deposit.list') || request()->routeIs('admin.deposit.method'))
            <div class="col-12">
                @include('admin.deposit.widget')
            </div>
        @endif

        <div class="col-md-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Gateway | Type')</th>
                                    <th>@lang('Initiated')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($deposits as $deposit)
                                    @php
                                        $details = $deposit->detail ? json_encode($deposit->detail) : null;
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="fw-bold">     {{ $deposit->currency }}</span> <br>
                                            <small> {{ $deposit->type }} </small>
                                        </td>

                                        <td>
                                            {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                        </td>
                                        <td>
    @if ($deposit->user)
        <span class="fw-bold">{{ $deposit->user->fullname }}</span>
        <br>
        <span class="small">
            <a href="{{ appendQuery('search', $deposit->user->username) }}">
                <span>@</span>{{ $deposit->user->username }}
            </a>
        </span>
    @else
        <span class="fw-bold text-danger">Unknown User</span>
        <br>
        <span class="small text-muted">User not found</span>
    @endif
</td>

                                        <td>
                                            {{ showAmount($deposit->amount, currencyFormat:false) }} + <span class="text--danger" title="@lang('charge')">{{ showAmount($deposit->charge, currencyFormat:false) }} </span>
                                            <br>
                                            <strong title="@lang('Amount with charge')">
                                                {{ showAmount($deposit->amount + $deposit->charge, currencyFormat:false) }} {{ __($deposit->method_currency) }}
                                            </strong>
                                        </td>
                                        <td>
                                            @php echo $deposit->statusBadge @endphp
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.deposit.details', $deposit->id) }}" class="btn btn-sm btn-outline--primary ms-1">
                                                <i class="la la-desktop"></i> @lang('Details')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($deposits->hasPages())
                    <div class="card-footer py-4">
                        @php echo paginateLinks($deposits) @endphp
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form dateSearch='yes' placeholder='Username / TRX' />
@endpush
