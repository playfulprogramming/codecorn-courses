<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'two_factor_code',
        'two_factor_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_expires_at' => 'datetime',
    ];

    /**
     * @comment Generate a two factor code.
     *
     * @return void
     */
    public function generateTwoFactorCode(): void
    {
        $this->timestamps = false;
        $this->two_factor_code = random_int(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    /**
     * @comment Reset the two factor code.
     *
     * @return void
     */
    public function resetTwoFactorCode(): void
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    /**
     * @comment Determine if the two factor code is expired.
     *
     * @return bool
     */
    public function twoFactorCodeExpired(): bool
    {
        return $this->two_factor_expires_at->isPast();
    }

    /**
     * @comment Determine if the two factor code is valid.
     *
     * @return bool
     */
    public function twoFactorCodeIsValid(int $code): bool
    {
        return $this->two_factor_code === $code;
    }

    /**
     * @comment Determine if the user has two factor authentication enabled.
     *
     * @return bool
     */
    public function twoFactorEnabled(): bool
    {
        return !is_null($this->two_factor_code);
    }

    /**
     * @comment Disable two factor authentication.
     *
     * @return void
     */
    public function disableTwoFactor(): void
    {
        $this->timestamps = false;
        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }
}
