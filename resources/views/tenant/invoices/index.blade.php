@extends('layouts.tenant')

@section('title', 'Invoices')
@section('page_title', 'Invoices')

@section('content')
<div class="space-y-6">

    <div class="flex justify-between items-center">
        <h2 class="text-white text-lg font-semibold">All Invoices</h2>

        <a href="{{ route('tenant.invoices.create') }}"
           class="px-4 py-2 bg-brand-600 text-white rounded-lg text-sm hover:bg-brand-700">
            + Create Invoice
        </a>
    </div>

    <form method="GET" class="bg-surface-800 border border-surface-700 rounded-xl p-4">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-3">
            <select name="status" class="bg-surface-900 border border-surface-700 rounded px-3 py-2 text-sm text-surface-300">
                <option value="">All Statuses</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>
                        {{ ucfirst(str_replace('_', ' ', $status)) }}
                    </option>
                @endforeach
            </select>

            <select name="brand_id" class="bg-surface-900 border border-surface-700 rounded px-3 py-2 text-sm text-surface-300">
                <option value="">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}" @selected((string) request('brand_id') === (string) $brand->id)>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>

            <input type="date" name="date_from" value="{{ request('date_from') }}" class="bg-surface-900 border border-surface-700 rounded px-3 py-2 text-sm text-surface-300" placeholder="From">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="bg-surface-900 border border-surface-700 rounded px-3 py-2 text-sm text-surface-300" placeholder="To">
            <input type="number" step="0.01" name="amount_min" value="{{ request('amount_min') }}" class="bg-surface-900 border border-surface-700 rounded px-3 py-2 text-sm text-surface-300" placeholder="Min Amount">
            <input type="number" step="0.01" name="amount_max" value="{{ request('amount_max') }}" class="bg-surface-900 border border-surface-700 rounded px-3 py-2 text-sm text-surface-300" placeholder="Max Amount">
        </div>

        <div class="mt-3 flex items-center gap-3">
            <button class="px-4 py-2 bg-brand-600 text-white rounded-lg text-sm hover:bg-brand-700">Apply Filters</button>
            <a href="{{ route('tenant.invoices.index') }}" class="text-sm text-surface-400 hover:text-white">Reset</a>
        </div>
    </form>

    <div class="bg-surface-800 border border-surface-700 rounded-xl overflow-hidden">
        <table class="w-full">
            <thead class="bg-surface-700/50 text-surface-400 text-xs uppercase">
                <tr>
                    <th class="px-6 py-4 text-left">Invoice</th>
                    <th class="px-6 py-4">Brand</th>
                    <th class="px-6 py-4">Amount</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-700">
                @forelse($invoices as $invoice)
                <tr class="hover:bg-surface-700/30">
                    <td class="px-6 py-4 text-white">
                        {{ $invoice->invoice_number }}
                    </td>
                    <td class="px-6 py-4 text-surface-400">
                        {{ $invoice->brand->name }}
                    </td>
                    <td class="px-6 py-4 text-surface-400 font-mono">
                        ₹{{ number_format($invoice->total_amount, 0) }}
                    </td>
                    <td class="px-6 py-4 text-surface-400">
                        {{ ucfirst($invoice->status) }}
                    </td>
                    <td class="px-6 py-4 space-x-2">
                        <a href="{{ route('tenant.invoices.show', $invoice) }}"
                           class="text-brand-400 text-sm">
                           View
                        </a>

                        <form action="{{ route('tenant.invoices.destroy', $invoice) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 text-sm"
                                onclick="return confirm('Delete invoice?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-surface-500">
                        No invoices yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $invoices->links() }}

</div>
@endsection