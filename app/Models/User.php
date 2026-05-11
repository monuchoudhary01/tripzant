<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($user) {
            if (!empty($user->role) && empty($user->role_id)) {
                $role = Role::where('slug', $user->role)->first();
                if ($role) {
                    $user->role_id = $role->id;
                }
            }
        });
    }

    const ROLE_SUPER_ADMIN = 'super-admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_AGENT = 'agent';
    const ROLE_IATA = 'iata';
    const ROLE_CORPORATE = 'corporate';
    const ROLE_INVESTOR = 'investor';
    const ROLE_HOTEL_PARTNER = 'hotel-partner';
    const ROLE_AMADEUS_PARTNER = 'amadeus-partner';
    const ROLE_TOUR_BUILDER = 'tour-builder';
    const ROLE_LOCAL_PROVIDER = 'local-provider';
    const ROLE_ACCOUNTING = 'accounting';
    const ROLE_CARGO = 'cargo';
    const ROLE_AFFILIATE = 'affiliate';
    const ROLE_PARTNER = 'partner';
    const ROLE_VISA_PROVIDER = 'visa-provider';
    const ROLE_IATA_NETWORK = 'iata-network';
    const ROLE_EXPLORER = 'explorer';

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
            case self::ROLE_ADMIN: return '/admin-dashboard';
            case self::ROLE_SUPER_ADMIN: return '/admin-dashboard';
            case self::ROLE_AGENT: return '/agent-dashboard';
            case self::ROLE_IATA: return '/iata-dashboard';
            case self::ROLE_HOTEL_PARTNER: return '/hotel-dashboard';
            case self::ROLE_CORPORATE: return '/corporate-dashboard';
            case self::ROLE_TOUR_BUILDER: return '/tourbuilder-dashboard';
            case self::ROLE_AMADEUS_PARTNER: return '/amadeus-dashboard';
            case self::ROLE_INVESTOR: return '/investor/dashboard';
            case self::ROLE_ACCOUNTING: return '/accounting/dashboard';
            case self::ROLE_CARGO: return '/user-cargo'; // Default cargo entry
            case self::ROLE_AFFILIATE: return '/affiliate-dashboard';
            case self::ROLE_PARTNER: return '/partner/dashboard';
            case self::ROLE_VISA_PROVIDER: return '/visa';
            case self::ROLE_IATA_NETWORK: return '/agent/dashboard';
            case self::ROLE_LOCAL_PROVIDER: return '/local-provider/dashboard';
            case self::ROLE_EXPLORER: return '/explorer/trends';
            case self::ROLE_USER: return '/dashboard';
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

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}
