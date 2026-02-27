<?php
// app/Models/Tenant.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'owner_id',
        'plan',
        'status',
        'trial_ends_at',
        'logo',
        'settings',
        'settings_draft',
        'business_logo',
        'business_name',
        'business_address',
        'business_phone',
        'business_email',
        'gstin',
        'pan',
        'state',
        'state_code',
        'business_type',
        'gst_registered',
        'gst_rate',
        'tds_rate',
        'bank_name',
        'bank_account',
        'bank_ifsc',
        'upi_id',
        'instagram_url',
        'youtube_url',
        'twitter_url',
        'website_url',
        'invoice_notes',
        'invoice_terms',
    ];

    protected $casts = [
        'settings' => 'array',
        'settings_draft' => 'array',
        'trial_ends_at' => 'datetime',
        'gst_registered' => 'boolean',
    ];

    // Relationships
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Helpers
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function onTrial()
    {
        return $this->status === 'trial' && $this->trial_ends_at?->isFuture();
    }
    
    public function teamMembers()
{
    return $this->hasMany(\App\Models\TeamMember::class);
}
}