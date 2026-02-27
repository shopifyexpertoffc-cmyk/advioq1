@extends('layouts.tenant')

@section('title', 'Settings')
@section('page_title', 'Settings')

@section('content')
@php
    $step = request('step', 'business');
    $steps = ['business', 'gst', 'bank', 'social', 'invoice'];
    $stepIndex = array_search($step, $steps);
@endphp

<div class="flex justify-center">
    <div class="w-full max-w-xl">

        {{-- Stepper --}}
        <div class="flex space-x-4 mb-8">
            @foreach($steps as $i => $s)
                <div class="flex-1 text-center">
                    <div class="text-xs {{ $step == $s ? 'text-brand-400 font-bold' : 'text-surface-400' }}">
                        {{ ucfirst($s) }}
                    </div>
                    <div class="h-1 {{ $step == $s ? 'bg-brand-500' : 'bg-surface-700' }} rounded"></div>
                </div>
            @endforeach
        </div>

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-0">
            @csrf
            <input type="hidden" name="step" value="{{ $step }}">

            {{-- Business Step --}}
            @if($step == 'business')
            <div class="bg-surface-800 rounded-xl p-8 mb-8">
                <h3 class="text-lg font-semibold text-white mb-6">Business Profile</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Business Name *</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $tenant->business_name) }}" required class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Business Email</label>
                        <input type="email" name="business_email" value="{{ old('business_email', $tenant->business_email) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Phone</label>
                        <input type="text" name="business_phone" value="{{ old('business_phone', $tenant->business_phone) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Address</label>
                        <input type="text" name="business_address" value="{{ old('business_address', $tenant->business_address) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                </div>
            </div>
            @endif

            {{-- GST Step --}}
            @if($step == 'gst')
            <div class="bg-surface-800 rounded-xl p-8 mb-8">
                <h3 class="text-lg font-semibold text-white mb-6">GST & Tax Settings</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">GSTIN</label>
                        <input type="text" name="gstin" value="{{ old('gstin', $tenant->gstin) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">PAN</label>
                        <input type="text" name="pan" value="{{ old('pan', $tenant->pan) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">State</label>
                        <input type="text" name="state" value="{{ old('state', $tenant->state) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">State Code</label>
                        <input type="text" name="state_code" value="{{ old('state_code', $tenant->state_code) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Business Type</label>
                        <input type="text" name="business_type" value="{{ old('business_type', $tenant->business_type) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div class="flex items-center gap-2 mt-2">
                        <input type="checkbox" name="gst_registered" value="1" {{ $tenant->gst_registered ? 'checked' : '' }}>
                        <label class="text-sm text-surface-400">GST Registered?</label>
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Default GST Rate (%)</label>
                        <input type="number" name="gst_rate" value="{{ old('gst_rate', $tenant->gst_rate) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Default TDS Rate (%)</label>
                        <input type="number" name="tds_rate" value="{{ old('tds_rate', $tenant->tds_rate) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                </div>
            </div>
            @endif

            {{-- Bank Step --}}
            @if($step == 'bank')
            <div class="bg-surface-800 rounded-xl p-8 mb-8">
                <h3 class="text-lg font-semibold text-white mb-6">Bank Details</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Bank Name</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name', $tenant->bank_name) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Account Number</label>
                        <input type="text" name="bank_account" value="{{ old('bank_account', $tenant->bank_account) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">IFSC</label>
                        <input type="text" name="bank_ifsc" value="{{ old('bank_ifsc', $tenant->bank_ifsc) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">UPI ID</label>
                        <input type="text" name="upi_id" value="{{ old('upi_id', $tenant->upi_id) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                </div>
            </div>
            @endif

            {{-- Social Step --}}
            @if($step == 'social')
            <div class="bg-surface-800 rounded-xl p-8 mb-8">
                <h3 class="text-lg font-semibold text-white mb-6">Social Media & Website</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Instagram URL</label>
                        <input type="url" name="instagram_url" value="{{ old('instagram_url', $tenant->instagram_url) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">YouTube URL</label>
                        <input type="url" name="youtube_url" value="{{ old('youtube_url', $tenant->youtube_url) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Twitter URL</label>
                        <input type="url" name="twitter_url" value="{{ old('twitter_url', $tenant->twitter_url) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Website URL</label>
                        <input type="url" name="website_url" value="{{ old('website_url', $tenant->website_url) }}" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">
                    </div>
                </div>
            </div>
            @endif

            {{-- Invoice Step --}}
            @if($step == 'invoice')
            <div class="bg-surface-800 rounded-xl p-8 mb-8">
                <h3 class="text-lg font-semibold text-white mb-6">Invoice Defaults</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Default Invoice Notes</label>
                        <textarea name="invoice_notes" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">{{ old('invoice_notes', $tenant->invoice_notes) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm text-surface-400 mb-1">Default Invoice Terms</label>
                        <textarea name="invoice_terms" class="w-full bg-surface-900 border border-surface-700 rounded-lg px-4 py-2.5 text-white text-sm">{{ old('invoice_terms', $tenant->invoice_terms) }}</textarea>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex justify-between p-8">
                @if($stepIndex > 0)
                    <button name="prev" class="px-6 py-2 bg-surface-700 text-white rounded-lg text-sm hover:bg-surface-600">
                        ← Back
                    </button>
                @endif
                @if($stepIndex < count($steps) - 1)
                    <button name="next" class="px-6 py-2 bg-brand-600 text-white rounded-lg text-sm hover:bg-brand-700">
                        Save & Next →
                    </button>
                @else
                    <button name="submit" class="px-6 py-2 bg-brand-600 text-white rounded-lg text-sm hover:bg-brand-700">
                        Submit & Save
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>

<script>
function showTab(tab) {
    const steps = ['business', 'gst', 'bank', 'social', 'invoice'];
    steps.forEach(s => {
        document.getElementById('tab-' + s).classList.add('hidden');
    });
    document.getElementById('tab-' + tab).classList.remove('hidden');
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('font-semibold', 'text-white', 'border-b-2', 'border-brand-500', 'text-surface-400');
        if (btn.textContent.trim().toLowerCase().replace(/[^a-z]/g,'') === tab) {
            btn.classList.add('font-semibold', 'text-white', 'border-b-2', 'border-brand-500');
        } else {
            btn.classList.add('text-surface-400');
        }
    });
}
</script>
@endsection