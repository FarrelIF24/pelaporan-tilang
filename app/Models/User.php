<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'role',
        'password',
        'balance',
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
        'balance' => 'decimal:2',
    ];
    
    /**
     * Check if user is a Polantas (traffic officer)
     *
     * @return bool
     */
    public function isPolantas()
    {
        return $this->role === 'Polantas';
    }
    
    /**
     * Check if user is a Pelapor (reporter)
     *
     * @return bool
     */
    public function isPelapor()
    {
        return $this->role === 'Pelapor';
    }
    
    /**
     * Get the reports submitted by this user.
     */
    public function submittedReports()
    {
        return $this->hasMany(Report::class, 'reporter_id');
    }
    
    /**
     * Get the reports verified by this user.
     */
    public function verifiedReports()
    {
        return $this->hasMany(Report::class, 'verified_by');
    }
}
