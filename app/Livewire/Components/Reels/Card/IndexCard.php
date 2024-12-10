<?php

namespace App\Livewire\Components\Reels\Card;

use App\Models\Reel;
use App\Models\Rlike;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;

class IndexCard extends Component
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
        return view('livewire.components.reels.card.index-card', compact('reels'));
    }

    public function like($id)
    {
        $data = [
            'reel_id' => $id,
            'user_id' => Auth::user()->id,
        ];

        $like = Rlike::where($data);
        if($like->count() > 0){
            $like->delete();
        }else{
            Rlike::create($data);
        }

        $reel = Reel::find($id);

        if ($reel && $reel->user_id !== Auth::user()->id) {
            // Kirimkan notifikasi ke pemilik postingan
            Notification::make()
                ->title('Postingan Disukai')
                ->success()
                ->body(Auth::user()->name . ' menyukai postingan Anda')
                ->actions([
                    Action::make('View')
                        ->url('/reel/' . $reel->slug)
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase($reel->user);
        }

        return NULL;
    }
}
