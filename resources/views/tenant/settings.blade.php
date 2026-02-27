@extends('layouts.tenant')

@section('title', 'Settings')
@section('page_title', 'Settings')

@section('content')
@php
    $tabs = [
        'business' => 'Business',
        'gst' => 'GST',
        'bank' => 'Bank',
        'social' => 'Social',
        'invoice' => 'Invoice',
    ];

    $currentTab = old('active_tab', request('tab', 'business'));
    if (! array_key_exists($currentTab, $tabs)) {
        $currentTab = 'business';
    }
@endphp

<div class="max-w-6xl mx-auto">
    <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-12 gap-6">
        @csrf
        <input type="hidden" name="active_tab" id="active_tab" value="{{ $currentTab }}">


        @if(session('success'))
            <div class="md:col-span-12 bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="md:col-span-12 bg-red-500/10 border border-red-500/20 text-red-300 px-4 py-3 rounded-lg text-sm">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <aside class="md:col-span-3 bg-surface-800 rounded-xl p-4 h-fit">
            <h2 class="text-white text-base font-semibold mb-3">Settings Sections</h2>
            <nav class="space-y-2">
                @foreach($tabs as $key => $label)
                    <button
                        type="button"
                        class="tab-btn w-full text-left px-3 py-2 rounded-lg text-sm transition-colors {{ $currentTab === $key ? 'bg-brand-600/20 text-white border border-brand-500/40' : 'text-surface-300 hover:bg-surface-700' }}"
                        data-tab="{{ $key }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </aside>

        <section class="md:col-span-9">
            <div id="tab-business" class="tab-panel bg-surface-800 rounded-xl p-6 {{ $currentTab === 'business' ? '' : 'hidden' }}">
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

            <div id="tab-gst" class="tab-panel bg-surface-800 rounded-xl p-6 {{ $currentTab === 'gst' ? '' : 'hidden' }}">
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
                        <input type="checkbox" name="gst_registered" value="1" {{ old('gst_registered', $tenant->gst_registered) ? 'checked' : '' }}>
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

            <div id="tab-bank" class="tab-panel bg-surface-800 rounded-xl p-6 {{ $currentTab === 'bank' ? '' : 'hidden' }}">
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

            <div id="tab-social" class="tab-panel bg-surface-800 rounded-xl p-6 {{ $currentTab === 'social' ? '' : 'hidden' }}">
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

            <div id="tab-invoice" class="tab-panel bg-surface-800 rounded-xl p-6 {{ $currentTab === 'invoice' ? '' : 'hidden' }}">
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

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-brand-600 text-white rounded-lg text-sm hover:bg-brand-700">
                    Save Settings
                </button>
            </div>
        </section>
    </form>
</div>

<script>
(function () {
    const buttons = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.tab-panel');
    const activeTabInput = document.getElementById('active_tab');

    function setActiveTab(tab) {
        panels.forEach((panel) => {
            panel.classList.toggle('hidden', panel.id !== `tab-${tab}`);
        });

        buttons.forEach((button) => {
            const isActive = button.dataset.tab === tab;
            button.classList.toggle('bg-brand-600/20', isActive);
            button.classList.toggle('text-white', isActive);
            button.classList.toggle('border', isActive);
            button.classList.toggle('border-brand-500/40', isActive);
            button.classList.toggle('text-surface-300', !isActive);
            button.classList.toggle('hover:bg-surface-700', !isActive);
        });

        activeTabInput.value = tab;
    }

    buttons.forEach((button) => {
        button.addEventListener('click', () => setActiveTab(button.dataset.tab));
    });
})();
</script>
@endsection
