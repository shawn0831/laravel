<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
// notifications
use Illuminate\Notifications\Notifiable;
// Cashier
use Laravel\Cashier\Billable;

// Localizing Mailables
// User Preferred Locales
use Illuminate\Contracts\Translation\HasLocalePreference;

// (implements HasLocalePreference interface will automatically use user's prefered locale language when sending mailables or notifications to the user)
class User extends Authenticatable implements HasLocalePreference
{
    use Billable;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','trial_ends_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // data mutator
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'trial_ends_at',
    ];

    // 定義關聯
    public function messages(){
        return $this->hasmany(Message::class);
    }

    // 定義稅率 (定義在 Billable model)
    public function taxPercentage(){
        return 20;
    }

    // Localizing Mailables
    // User Preferred Locales
    public function preferredLocale(){
        return $this->locale;
    }
}
