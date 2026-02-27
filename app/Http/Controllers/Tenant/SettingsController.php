<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    $data = $request->validate([
        'business_logo' => 'nullable|image|max:2048',
        'business_name' => 'required|string|max:255',
        'business_email' => 'nullable|email|max:255',
        'business_phone' => 'nullable|string|max:20',
        'business_address' => 'nullable|string|max:255',
        'gstin' => 'nullable|string|max:15',
        'pan' => 'nullable|string|max:10',
        'state' => 'nullable|string|max:100',
        'state_code' => 'nullable|string|max:5',
        'business_type' => 'nullable|string|max:50',
        'gst_registered' => 'nullable|boolean',
        'gst_rate' => 'nullable|numeric|min:0|max:28',
        'tds_rate' => 'nullable|numeric|min:0|max:30',
        'bank_name' => 'nullable|string|max:100',
        'bank_account' => 'nullable|string|max:30',
        'bank_ifsc' => 'nullable|string|max:15',
        'upi_id' => 'nullable|string|max:50',
        'instagram_url' => 'nullable|url|max:255',
        'youtube_url' => 'nullable|url|max:255',
        'twitter_url' => 'nullable|url|max:255',
        'website_url' => 'nullable|url|max:255',
        'invoice_notes' => 'nullable|string|max:500',
        'invoice_terms' => 'nullable|string|max:500',
    ]);

    if ($request->hasFile('business_logo')) {
        $logo = $request->file('business_logo')->store('logos', 'public');
        $data['business_logo'] = $logo;
    }

    $data['gst_registered'] = $request->has('gst_registered');

    $tenant->update($data);

    return back()->with('success', 'Settings updated successfully.');
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
}