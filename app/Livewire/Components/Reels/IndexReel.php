<?php

namespace App\Livewire\Components\Reels;

use App\Models\Like;
use App\Models\Reel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class IndexReel extends Component
{
    public $count = 5;

    public function loadMore()
    {
        $this->count += 5;
        sleep(1);
    }

    public function render()
    {
        // $posts = Reel::take($this->count)
        //             ->where('published', true)
        //             ->latest()
        //             ->get();
        $reels = Reel::withCount(['comments','likes'])
                    ->where('published', true)
                    ->latest()
                    ->get();
        // $hide = Reel::count();
        return view('livewire.Components.Reels.index-reel', compact('reels'));
    }

    public function like($id)
    {
        $data = [
            'reel_id' => $id,
            'user_id' => Auth::user()->id,
        ];

        $like = Like::where($data);
        if($like->count() > 0){
            $like->delete();
        }else{
            Like::create($data);
        }

        return NULL;
    }
}
