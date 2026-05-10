@extends('layouts.app')

@section('title', 'Daily Sales Summary - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">Daily Sales Summary</h2>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 border-start border-primary border-4 h-100">
                    <div class="card-body p-4">
                        <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Total Revenue (30
                            Days)</h6>
                        <h3 class="mb-0 fw-bold text-dark">₱{{ number_format($revenueData->sum('daily_revenue'), 2) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 border-start border-success border-4 h-100">
                    <div class="card-body p-4">
                        <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Total Transactions
                        </h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ number_format($revenueData->sum('total_transactions')) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 border-start border-info border-4 h-100">
                    <div class="card-body p-4">
                        <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Avg. Transaction
                            Value</h6>
                        <h3 class="mb-0 fw-bold text-dark">
                            ₱{{ number_format($revenueData->avg('avg_transaction_value'), 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-graph-up-arrow text-primary me-2"></i>Recent Financial Performance
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Sales Date</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 text-center">Transactions</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 text-center">Daily Revenue</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 text-center">Avg. Per Sale</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($revenueData as $day)
                            <tr>
                                <td class="ps-4 py-3 fw-bold text-dark">
                                    {{ \Carbon\Carbon::parse($day->sales_date)->format('M d, Y') }}
                                    @if($day->sales_date == date('Y-m-d'))
                                        <span class="badge bg-primary ms-2" style="font-size: 0.65rem;">TODAY</span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    <span
                                        class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3">
                                        {{ $day->total_transactions }} txns
                                    </span>
                                </td>
                                <td class="py-3 text-center fw-bold text-success">
                                    ₱{{ number_format($day->daily_revenue, 2) }}
                                </td>
                                <td class="py-3 text-center text-muted">
                                    ₱{{ number_format($day->avg_transaction_value, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted d-flex flex-column align-items-center">
                                        <i class="bi bi-calendar-x fs-1 mb-2 opacity-50"></i>
                                        <span class="fw-medium">No sales summary data available</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection