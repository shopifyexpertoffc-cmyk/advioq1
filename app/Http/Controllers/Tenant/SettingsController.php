<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class SettingsController extends Controller
{
public function edit()
{
    $tenant = auth()->user()->tenant;
    return view('tenant.settings', compact('tenant'));
}

public function update(Request $request)
{
    $tenant = auth()->user()->tenant;

    $tab = $request->input('active_tab', 'business');

    $rulesByTab = [
        'business' => [
            'business_logo' => 'nullable|image|max:2048',
            'business_name' => 'required|string|max:255',
            'business_email' => 'nullable|email|max:255',
            'business_phone' => 'nullable|string|max:20',
            'business_address' => 'nullable|string|max:255',
        ],
        'gst' => [
            'gstin' => 'nullable|string|max:15',
            'pan' => 'nullable|string|max:10',
            'state' => 'nullable|string|max:100',
            'state_code' => 'nullable|string|max:5',
            'business_type' => 'nullable|string|max:50',
            'gst_registered' => 'nullable|boolean',
            'gst_rate' => 'nullable|numeric|min:0|max:28',
            'tds_rate' => 'nullable|numeric|min:0|max:30',
        ],
        'bank' => [
            'bank_name' => 'nullable|string|max:100',
            'bank_account' => 'nullable|string|max:30',
            'bank_ifsc' => 'nullable|string|max:15',
            'upi_id' => 'nullable|string|max:50',
        ],
        'social' => [
            'instagram_url' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
            'website_url' => 'nullable|string|max:255',
        ],
        'invoice' => [
            'invoice_notes' => 'nullable|string|max:500',
            'invoice_terms' => 'nullable|string|max:500',
        ],
    ];

    $rules = $rulesByTab[$tab] ?? $rulesByTab['business'];
    $data = $request->validate($rules);

    if ($request->hasFile('business_logo')) {
        $logo = $request->file('business_logo')->store('logos', 'public');
        $data['business_logo'] = $logo;
    }

    if ($tab === 'gst') {
        $data['gst_registered'] = $request->boolean('gst_registered');
    }

    if (Schema::hasColumn('tenants', 'settings') && ! isset($data['settings'])) {
        $data['settings'] = $this->normalizeJsonColumn($tenant->getAttribute('settings'));
    }

    if (Schema::hasColumn('tenants', 'settings_draft')) {
        $data['settings_draft'] = $this->normalizeJsonColumn($tenant->getAttribute('settings_draft'));
    }

    $tenant->forceFill($data)->save();

    return redirect()->route('settings', ['tab' => $tab])
        ->with('success', ucfirst($tab) . ' details updated successfully.');
}


public function saveStep(Request $request)
{
    $tenant = auth()->user()->tenant;

    $step = $request->input('step');
    $data = $request->except(['_token', 'step', 'next', 'prev', 'submit']);

    // Handle file upload for logo
    if ($request->hasFile('business_logo')) {
        $logo = $request->file('business_logo')->store('logos', 'public');
        $data['business_logo'] = $logo;
    }

    // Save each field as key/value
    foreach ($data as $key => $value) {
        \App\Models\TenantSetting::updateOrCreate(
            ['tenant_id' => $tenant->id, 'key' => $key],
            ['value' => $value]
        );
    }

    if ($request->has('next')) {
        return redirect()->route('tenant.settings', ['step' => $this->getNextStep($step)]);
    } elseif ($request->has('prev')) {
        return redirect()->route('tenant.settings', ['step' => $this->getPrevStep($step)]);
    } else {
        return redirect()->route('tenant.settings')->with('success', 'Settings saved!');
    }
}
private function getNextStep($step)
{
    $steps = ['business', 'gst', 'bank', 'social', 'invoice'];
    $index = array_search($step, $steps);
    return $steps[min($index + 1, count($steps) - 1)];
}

private function getPrevStep($step)
{
    $steps = ['business', 'gst', 'bank', 'social', 'invoice'];
    $index = array_search($step, $steps);
    return $steps[max($index - 1, 0)];
}

private function normalizeJsonColumn($value): string
{
    if (is_array($value)) {
        return json_encode($value, JSON_UNESCAPED_UNICODE) ?: '{}';
    }

    if (! is_string($value) || trim($value) === '') {
        return '{}';
    }

    json_decode($value);

    return json_last_error() === JSON_ERROR_NONE ? $value : '{}';
}
}
