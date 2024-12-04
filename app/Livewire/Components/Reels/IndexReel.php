<?php

namespace App\Livewire\Components\Reels;

use App\Models\Reel;
use Livewire\Component;

class IndexReel extends Component
{
    public function render()
    {
        $posts = Reel::where('published', true)->latest()->get();
        return view('livewire.Components.Reels.index-reel', compact('posts'));
    }
}
