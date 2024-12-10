<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $guarded =['id'];


    public function childrens(): HasMany
    {
        return $this->hasMany(Self::class, 'comment_id')->with('childrens');
    }


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($comment) {
            $comment->childrens()->delete();
        });
    }

    
    public function hasLike():HasOne
    {
        return $this->hasOne(Clike::class)->where('clikes.user_id',Auth::user()->id);
    }

    public function totalLikes()
    {
        return $this->hasMany(Clike::class)->count();
    }

}
