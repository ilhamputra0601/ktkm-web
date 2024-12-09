<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function likes()
    {
        return $this->hasMany(Rlike::class);
    }
    public function hasLike():HasOne
    {
        return $this->hasOne(Rlike::class)->where('rlikes.user_id',Auth::user()->id);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
