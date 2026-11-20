<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    // 2. Pasang HasApiTokens di dalam class
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tenant_id',
        'name',
        'email',
        'nik',
        'phone',
        'password',
        'role',
        'status',
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
     * Relasi ke Model Tenant
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function ownedKartuKeluargas(): HasMany
    {
        return $this->hasMany(KartuKeluarga::class, 'owner_user_id');
    }

    public function iurans(): HasMany
    {
        return $this->hasMany(Iuran::class);
    }

    public function surats(): HasMany
    {
        return $this->hasMany(Surat::class);
    }
}