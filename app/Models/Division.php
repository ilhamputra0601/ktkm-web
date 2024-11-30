<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Division extends Model
{
    protected $guarded = ['id'];
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Delete logo file when the user is deleted
        static::deleting(function ($divisi) {
            if ($divisi->logo_url) {
                Storage::disk('public')->delete($divisi->logo_url);
            }
        });

        // Delete old logo file when the logo is updated
        static::updating(function ($divisi) {
            $originalLogo = $divisi->getOriginal('logo_url'); // logo before update
            $newLogo = $divisi->logo_url; // logo after update

            // If the logo is being updated, delete the old file
            if ($originalLogo && $originalLogo !== $newLogo) {
                Storage::disk('public')->delete($originalLogo);
            }
        });
    }
}
