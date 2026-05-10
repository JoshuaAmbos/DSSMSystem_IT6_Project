@extends('layouts.app')

@section('title', 'Active Inventory - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Active Inventory List</h2>
                <p class="text-muted mb-0 small">Only <strong>Available</strong> items.
                </p>
            </div>
            <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary shadow-sm px-3">
                <i class="bi bi-arrow-left me-2"></i>Back to Hub
            </a>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div
                    class="card border-0 shadow-sm rounded-3 border-start border-warning border-4 bg-warning bg-opacity-10">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.8rem;">Current Market
                                Value of Stock</h6>
                            <h2 class="mb-0 fw-bold text-dark">₱{{ number_format($totalPotentialValue, 2) }}</h2>
                        </div>
                        <i class="bi bi-piggy-bank fs-1 text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-box-seam text-warning me-2"></i>Live Stock Report
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Item Code</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Category</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Description</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 text-end">Price</th>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($inventory as $item)
                            <tr>
                                <td class="ps-4 py-3 fw-bold text-primary">{{ $item->item_code }}</td>
                                <td class="py-3 text-secondary text-truncate" style="max-width: 250px;">
                                    {{ $item->category_name }}
                                </td>
                                <td class="py-3 text-secondary text-truncate" style="max-width: 250px;">
                                    {{ $item->item_name ?? 'No description' }}
                                </td>
                                <td class="py-3 fw-bold text-end">₱{{ number_format($item->tag_price, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted d-flex flex-column align-items-center">
                                        <i class="bi bi-box-x fs-1 mb-2 opacity-50"></i>
                                        <span class="fw-medium">No active inventory items found</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($inventory->hasPages())
                <div class="card-footer bg-white border-top p-3">
                    {{ $inventory->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection