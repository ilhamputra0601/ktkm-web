<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reel extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'images' => 'array',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected static function booted()
    {
        static::creating(function ($reel) {
            $reel->user_id = auth()->id();
        });

        static::deleting(function ($reel) {
        Storage::disk('public')->delete($reel->images);
        });

        static::updating(function ($reel) {
            // Get original images (before the update)
            $originalImages = $reel->getOriginal('images');

            // Get updated images
            $updatedImages = $reel->images;

            // Check for images that were removed
            $deletedImages = array_diff($originalImages, $updatedImages);

            // Delete the removed files
            foreach ($deletedImages as $image) {
                Storage::disk('public')->delete($image);
            }
        });

    }
}
