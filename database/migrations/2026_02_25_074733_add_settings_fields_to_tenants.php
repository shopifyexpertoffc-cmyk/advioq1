<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('tenants', function (Blueprint $table) {
        $table->string('business_logo')->nullable();
        $table->string('business_name')->nullable();
        $table->string('business_address')->nullable();
        $table->string('business_phone')->nullable();
        $table->string('business_email')->nullable();
        $table->string('gstin', 15)->nullable();
        $table->string('pan', 10)->nullable();
        $table->string('state')->nullable();
        $table->string('state_code', 5)->nullable();
        $table->string('business_type')->nullable();
        $table->boolean('gst_registered')->default(false);
        $table->decimal('gst_rate', 5, 2)->default(18.00);
        $table->decimal('tds_rate', 5, 2)->default(10.00);
        $table->string('bank_name')->nullable();
        $table->string('bank_account')->nullable();
        $table->string('bank_ifsc')->nullable();
        $table->string('upi_id')->nullable();
        $table->string('instagram_url')->nullable();
        $table->string('youtube_url')->nullable();
        $table->string('twitter_url')->nullable();
        $table->string('website_url')->nullable();
        $table->text('invoice_notes')->nullable();
        $table->text('invoice_terms')->nullable();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tenants', function (Blueprint $table) {
            //
        });
    }
};
