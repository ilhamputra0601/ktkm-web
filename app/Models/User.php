<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable  implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'division_id',
        'password',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];

    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (is_null($user->division_id)) {
                $user->division_id = 4;
            }

            if (!$user->hasAnyRole('')) {
                $user->assignRole('Pengunjung');
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(['Super Admin','Admin','Pengurus','Anggota','Pengunjung']);

    }

    public function division():BelongsTo
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function reel(): HasMany
    {
        return $this->hasMany(Reel::class);
    }
}
