<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable  implements FilamentUser, MustVerifyEmail
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
        'password',
        'division_id',
        'avatar_url',
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

        // Delete avatar file when the user is deleted
        static::deleting(function ($user) {
            if ($user->avatar_url) {
                Storage::disk('public')->delete($user->avatar_url);
            }
        });

        // Delete old avatar file when the avatar is updated
        static::updating(function ($user) {
            $originalAvatar = $user->getOriginal('avatar_url'); // Avatar before update
            $newAvatar = $user->avatar_url; // Avatar after update

            // If the avatar is being updated, delete the old file
            if ($originalAvatar && $originalAvatar !== $newAvatar) {
                Storage::disk('public')->delete($originalAvatar);
            }
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($this->hasRole(['Developer']) && $this->hasVerifiedEmail() || $this->hasVerifiedEmail()){
            return true;
        }
        return true;
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
