@extends('layouts.admin')

@section('title', 'Analytics')
@section('page_title', 'Platform Analytics')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-surface-800 border border-surface-700 rounded-xl p-4"><p class="text-surface-400 text-xs">Total Tenants</p><p class="text-2xl font-semibold">{{ $metrics['totalTenants'] }}</p></div>
    <div class="bg-surface-800 border border-surface-700 rounded-xl p-4"><p class="text-surface-400 text-xs">Active</p><p class="text-2xl font-semibold">{{ $metrics['activeTenants'] }}</p></div>
    <div class="bg-surface-800 border border-surface-700 rounded-xl p-4"><p class="text-surface-400 text-xs">Trial</p><p class="text-2xl font-semibold">{{ $metrics['trialTenants'] }}</p></div>
    <div class="bg-surface-800 border border-surface-700 rounded-xl p-4"><p class="text-surface-400 text-xs">Invoice Volume</p><p class="text-2xl font-semibold">{{ $metrics['invoiceVolume'] }}</p></div>
    <div class="bg-surface-800 border border-surface-700 rounded-xl p-4"><p class="text-surface-400 text-xs">Revenue</p><p class="text-2xl font-semibold">₹{{ number_format($metrics['totalRevenue'], 2) }}</p></div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-surface-800 border border-surface-700 rounded-xl p-5">
        <h3 class="font-semibold mb-4">Revenue by Plan</h3>
        <div class="space-y-2">
            @forelse($revenueByPlan as $plan => $count)
                <div class="flex justify-between text-sm border-b border-surface-700 pb-2">
                    <span class="capitalize">{{ $plan }}</span>
                    <span>{{ $count }} tenants</span>
                </div>
            @empty
                <p class="text-surface-400 text-sm">No plan data available.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-surface-800 border border-surface-700 rounded-xl p-5">
        <h3 class="font-semibold mb-4">Tenant Growth (Last 30 days)</h3>
        <div class="space-y-2 max-h-72 overflow-auto">
            @forelse($tenantGrowth as $item)
                <div class="flex justify-between text-sm border-b border-surface-700 pb-2">
                    <span>{{ \Carbon\Carbon::parse($item->day)->format('d M Y') }}</span>
                    <span>{{ $item->total }}</span>
                </div>
            @empty
                <p class="text-surface-400 text-sm">No growth data available.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
