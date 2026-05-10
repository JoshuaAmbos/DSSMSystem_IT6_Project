@extends('layouts.app')

@section('title', 'Reports Hub - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">System Reports & Analytics</h2>
            <span class="badge bg-primary rounded-pill px-3 py-2">Database View-Driven</span>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-12">
                <div
                    class="card border-0 shadow-sm rounded-3 bg-primary bg-opacity-10 border-start border-primary border-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-primary mb-2">Welcome to the Reports Hub</h5>
                        <p class="text-dark mb-0">Select a report below to view processed data directly from the system's
                            optimized database views.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-cash-stack text-success me-2"></i>Financial
                            Reports</h5>
                    </div>
                    <div class="card-body p-4 d-flex flex-column gap-3">

                        <div class="d-flex align-items-start p-3 border rounded-3 hover-bg-light">
                            <div class="bg-success bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="bi bi-graph-up-arrow text-success fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">Daily Sales Summary</h6>
                                <p class="small text-muted mb-2">Overview of revenue, transaction counts, and average sale
                                    value per day.</p>
                                <a href="{{ route('reports.daily-sales-summary') }}"
                                    class="btn btn-sm btn-success px-3">Open Report</a>
                            </div>
                        </div>

                        <div class="d-flex align-items-start p-3 border rounded-3 hover-bg-light">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="bi bi-box-seam text-warning fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">Active Inventory List</h6>
                                <p class="small text-muted mb-2">Real-time list of available items on the floor and their
                                    total market value.
                                </p>
                                <a href="{{ route('reports.current-active-inventory') }}"
                                    class="btn btn-sm btn-warning text-dark px-3">Open Report</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-box-seam text-info me-2"></i>Inventory Analytics
                        </h5>
                    </div>
                    <div class="card-body p-4 d-flex flex-column gap-3">

                        <div class="d-flex align-items-start p-3 border rounded-3 hover-bg-light">
                            <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="bi bi-tags text-info fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1">Category Inventory Status</h6>
                                <p class="small text-muted mb-2">Stock levels, availability percentages, and potential
                                    revenue per category.</p>
                                <a href="{{ route('reports.inventory-status') }}"
                                    class="btn btn-sm btn-info text-white px-3">Open Report</a>
                            </div>
                        </div>

                        <div class="d-flex align-items-start p-3 border rounded-3 border-dashed opacity-75">
                            <div class="bg-secondary bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="bi bi-hourglass-split text-secondary fs-4"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1 text-muted">Bale Profitability (Pending)</h6>
                                <p class="small text-muted mb-2">Compare purchase price vs. actual earnings per bale.
                                    (Future View)</p>
                                <button class="btn btn-sm btn-secondary disabled px-3">Coming Soon</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-bg-light:hover {
            background-color: #f8f9fa;
            transition: 0.2s ease-in-out;
        }

        .border-dashed {
            border-style: dashed !important;
        }
    </style>
@endsection