# Easitrip B2B Portal: Database Schema & Logic Guide

This document defines the database architecture and authentication logic required for the multi-role travel portal.

## 🗄️ Database Details
*   **Database Name:** `easitrip_db`
*   **Engine:** MySQL / MariaDB (Standard for Laravel)

---

## 📋 Table Definitions

### 1. `users` (Core Auth)
Stores basic credentials and role identification.

| Column | Type | Description |
| :--- | :--- | :--- |
| `id` | BigInt (PK) | Unique User ID |
| `name` | String | Full Name / Legal Name |
| `email` | String (Unique) | Primary Login Username |
| `phone` | String | Verified Mobile Number |
| `role` | String | Role ID: `super_admin`, `iata_agent`, `amadeus_partner`, `corporate`, `hotel_partner`, `tour_supplier`, `b2b_agent` |
| `status` | String | Account state: `pending`, `active`, `suspended` |
| `password` | Hash | Encrypted login password |
| `email_verified_at` | Timestamp | For security verification |

### 2. `iata_agent_profiles`
Specific data for IATA accredited agents.

| Column | Type | Description |
| :--- | :--- | :--- |
| `user_id` | Foreign Key | Link to `users.id` |
| `iata_code` | String | 7-digit numeric IATA code |
| `agency_name` | String | Registered agency name |
| `license_no` | String | Govt. registration number |

### 3. `hotel_partner_profiles`
Data for property owners/managers.

| Column | Type | Description |
| :--- | :--- | :--- |
| `user_id` | Foreign Key | Link to `users.id` |
| `property_name` | String | Name of the primary property |
| `property_type` | String | Hotel, Resort, Guest House, etc. |
| `gst_number` | String | Tax ID for invoicing |

### 4. `wallets` (Financial)
Connected to Agents and Partners for instant ticketing.

| Column | Type | Description |
| :--- | :--- | :--- |
| `user_id` | Foreign Key | Link to `users.id` |
| `balance` | Decimal(15,2) | Available credit for bookings |
| `credit_limit` | Decimal(15,2) | Allowed negative balance (for trusted partners) |

---

## 🔄 Login & Redirection Logic

When a user logs in, the system checks their `role` field and redirects them to their specific dashboard.

### Logic Flow (Pseudocode):
```php
public function authenticated(Request $request, $user)
{
    // 1. Check if account is active
    if ($user->status !== 'active') {
        Auth::logout();
        return redirect('/login')->with('error', 'Your account is pending verification.');
    }

    // 2. Redirect based on role
    switch ($user->role) {
        case 'super_admin':
            return redirect('/admin/dashboard');
        case 'iata_agent':
            return redirect('/iata/dashboard');
        case 'hotel_partner':
            return redirect('/supplier/dashboard');
        case 'corporate':
            return redirect('/corporate/dashboard');
        case 'amadeus_partner':
            return redirect('/amadeus/dashboard');
        default:
            return redirect('/dashboard');
    }
}
```

## 🛠️ Implementation Steps
1.  **Configure `.env`**: Set `DB_DATABASE=easitrip_db`.
2.  **Run Migrations**: Use `php artisan migrate` to create all tables.
3.  **Seed Data**: (Optional) Use `php artisan db:seed` to create a default Super Admin.
