<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class AdminAnalyticsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_analytics_metrics(): void
    {
        $admin = User::factory()->create(['is_system_admin' => true]);

        $owner = User::factory()->create();
        Tenant::create([
            'name' => 'Trial Tenant',
            'slug' => 'trial-tenant',
            'owner_id' => $owner->id,
            'plan' => 'free',
            'status' => 'trial',
        ]);

        $owner2 = User::factory()->create();
        $activeTenant = Tenant::create([
            'name' => 'Pro Tenant',
            'slug' => 'pro-tenant',
            'owner_id' => $owner2->id,
            'plan' => 'pro',
            'status' => 'active',
        ]);

        $brand = Brand::create([
            'tenant_id' => $activeTenant->id,
            'name' => 'Acme Brand',
            'email' => 'billing@acme.test',
            'status' => 'active',
        ]);

        Invoice::create([
            'tenant_id' => $activeTenant->id,
            'brand_id' => $brand->id,
            'invoice_number' => 'INV-1001',
            'public_token' => Str::random(40),
            'issue_date' => now()->toDateString(),
            'due_date' => now()->addDays(15)->toDateString(),
            'subtotal' => 1000,
            'taxable_amount' => 1000,
            'total_amount' => 1000,
            'amount_paid' => 0,
            'balance_due' => 1000,
            'currency' => 'INR',
            'status' => 'sent',
        ]);

        Payment::create([
            'tenant_id' => $activeTenant->id,
            'invoice_id' => null,
            'brand_id' => $brand->id,
            'amount' => 5000,
            'payment_date' => now()->toDateString(),
            'payment_method' => 'bank_transfer',
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.analytics'));

        $response->assertOk();
        $response->assertSee('Platform Analytics');
        $response->assertSee('Total Tenants');
        $response->assertSee('Invoice Volume');
        $response->assertSee('Revenue by Plan');
    }
}
