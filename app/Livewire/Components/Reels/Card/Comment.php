<?php

namespace App\Livewire\Components\Reels\Card;

use App\Models\Reel;
use App\Models\Clike;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment as CommentModel;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;


class Comment extends Component
{

    public $reel, $body, $body_2, $edit_comment_id, $reply_comment_id;

    public function mount($id)
    {
        $this->reel = Reel::find($id);
    }


    public function render()
    {
        return view('livewire.components.reels.card.comment', [
            'comments' => CommentModel::with(['user', 'childrens'])
                ->where('reel_id', $this->reel->id)
                ->whereNull('comment_id')->latest()->get(),
            'total_comments' => CommentModel::where('reel_id', $this->reel->id)->count(),
        ]);
    }

    public function store()
    {
        $this->validate([
            'body' => 'required|string|max:255',
        ]);

        $comment = CommentModel::create([
            'user_id' => Auth::user()->id,
            'reel_id' => $this->reel->id,
            'body' => $this->body,
        ]);


        // Cari pemilik reel
        $reel = $this->reel;

        // Kirimkan notifikasi jika pemilik reel bukan pengguna yang sedang login
        if ($reel && $reel->user_id !== Auth::user()->id) {
            Notification::make()
                ->title('Komentar Baru')
                ->success()
                ->body(Auth::user()->name . ' mengomentari postingan Anda: "' . $this->body . '"')
                ->actions([
                    Action::make('Lihat')
                        ->url('/reel/' . $reel->slug)
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase($reel->user);
        }

        if ($comment) {
            // return redirect('/reel/'.$this->reel->slug)->with('success','komentar berhasil dibuat');
            $this->reset('body');
        } else {
            return redirect('/reel/' . $this->reel->slug)->with('fail', 'komentar gagal dibuat.');
        }
    }

    public function reply($id)
    {
        $this->reply_comment_id = $id;
        $this->edit_comment_id = NULL;
        $this->body_2 = NULL;
    }

    public function replyStore()
    {
        $this->validate([
            'body_2' => 'required|string|max:255',
        ]);
        $comment = CommentModel::find($this->reply_comment_id);
        $comment = CommentModel::create([
            'user_id' => Auth::user()->id,
            'reel_id' => $this->reel->id,
            'body' => $this->body_2,
            'comment_id' => $comment->comment_id ? $comment->comment_id : $comment->id
        ]);

        // $parentComment = CommentModel::find($this->reply_comment_id);

        // $comment = CommentModel::create([
        //     'user_id' => Auth::user()->id,
        //     'reel_id' => $this->reel->id,
        //     'body' => $this->body_2,
        //     'comment_id' => $parentComment ? $parentComment->id : null, // Tetapkan parent jika ada
        // ]);

        // // Kirimkan notifikasi ke pemilik komentar jika bukan pengguna yang sama
        // if ($parentComment && $parentComment->user_id !== Auth::user()->id) {
        //     Notification::make()
        //         ->title('Balasan Komentar Baru')
        //         ->success()
        //         ->body(Auth::user()->name . ' membalas komentar Anda: "' . $this->body_2 . '"')
        //         ->actions([
        //             Action::make('Lihat')
        //                 ->url('/reel/' . $this->reel->slug)
        //                 ->button()
        //                 ->markAsRead(),
        //         ])
        //         ->sendToDatabase($parentComment->user);
        // }


        if ($comment) {
            $this->reset('body');
            $this->reset('reply_comment_id');
        } else {
            return redirect('/reel/' . $this->reel->slug)->with('fail', 'komentar gagal diubah.');
        }
    }


    public function edit($id)
    {
        $comment = CommentModel::find($id);
        $this->edit_comment_id = $comment->id;
        $this->body_2 = $comment->body;
        $this->reply_comment_id = NULL;
    }

    public function editStore()
    {
        $this->validate([
            'body_2' => 'required|string|max:255',
        ]);

        $comment = CommentModel::where('id', $this->edit_comment_id)->update([
            'body' => $this->body_2,
        ]);

        if ($comment) {
            $this->reset('body');
            $this->edit_comment_id = false;
        } else {
            return redirect('/reel/' . $this->reel->slug)->with('fail', 'komentar gagal diubah.');
        }
    }

    public function delete($id)
    {
        $comment = CommentModel::where('id', $id)->delete();

        if ($comment) {
            return redirect('/reel/' . $this->reel->slug)->with('success', 'komentar berhasil dihapus');
        } else {
            return redirect('/reel/' . $this->reel->slug)->with('fail', 'komentar gagal dihapus.');
        }
    }

    public function like($id)
    {
        $data = [
            'comment_id' => $id,
            'user_id' => Auth::user()->id,
        ];

        $like = Clike::where($data);
        if ($like->count() > 0) {
            $like->delete();
        } else {
            Clike::create($data);
        }

        // comment
        $comment = CommentModel::find($id); // Ambil komentar yang dilike

        if ($comment && $comment->user_id !== Auth::user()->id) {
            // Kirimkan notifikasi ke pemilik komentar
            Notification::make()
                ->title('Komentar Disukai')
                ->success()
                ->body(Auth::user()->name . ' menyukai komentar Anda: "' . $comment->body . '"')
                ->actions([
                    Action::make('Lihat')
                        ->url('/reel/' . $this->reel->slug)
                        ->button()
                        ->markAsRead(),
                ])
                ->sendToDatabase($comment->user);
        }

        return NULL;
    }
}
