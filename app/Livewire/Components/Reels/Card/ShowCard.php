<?php

namespace App\Livewire\Components\Reels\Card;

use App\Models\Reel;
use App\Models\Rlike;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class ShowCard extends Component
{
    public $reel;

    public function mount(Reel $reel)
    {

        $this->reel = $reel->loadCount(['comments', 'likes']);
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.components.reels.card.show-card', [
            'reel' => $this->reel,
        ]);
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
                ->sendToDatabase($reel->user);
        }

        return NULL;
    }
}
