<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_SUPER_ADMIN = 'super-admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_B2B_AGENT = 'b2b';
    const ROLE_IATA_AGENT = 'iata';
    const ROLE_HOTEL_PARTNER = 'hotel-partner';
    const ROLE_CORPORATE = 'corporate';
    const ROLE_TOUR_SUPPLIER = 'supplier';
    const ROLE_AMADEUS_PARTNER = 'amadeus-partner';
    const ROLE_CUSTOMER = 'user';
    const ROLE_CARGO = 'cargo';
    const ROLE_AFFILIATE = 'affiliate';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'role', 'role_id', 'status', 'otp', 'is_verified',
        'created_by', 'company_name', 'gst_number', 'agency_name', 'address', 'contact_person', 'business_metadata',
        'affiliate_code', 'referred_by', 'service_category', 'pricing', 'is_approved', 'provider_location'
    ];

    protected $casts = [
        'business_metadata' => 'array',
    ];

    public function roleModel()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getDashboardUrl()
    {
        $roleSlug = $this->roleModel ? $this->roleModel->slug : $this->role;

        switch ($roleSlug) {
            case 'super-admin': return '/admin-dashboard';
            case 'admin': return '/admin-dashboard';
            case 'b2b': return '/agent-dashboard';
            case 'iata': return '/iata-dashboard';
            case 'hotel-partner': return '/hotel-dashboard';
            case 'corporate': return '/corporate';
            case 'supplier': return '/tourbuilder-dashboard';
            case 'amadeus-partner': return '/amadeus-dashboard';
            case 'cargo': return '/cargo-dashboard';
            case 'affiliate': return '/affiliate-dashboard';
            default: return '/dashboard';
        }
    }
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function moneyTransfers()
    {
        return $this->hasMany(MoneyTransfer::class);
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}
