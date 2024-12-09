<?php

namespace App\Livewire\Partials\Reel;

use App\Models\Like;
use App\Models\Reel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment as CommentModel;

class Comment extends Component
{
    public $reel, $body, $body_2, $edit_comment_id, $reply_comment_id;

    public function mount($id)
    {
        $this->reel = Reel::find($id);
    }


    public function render()
    {
        return view('livewire.partials.reel.comment',[
            'comments' => CommentModel::with(['user','childrens'])
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

        if ($comment) {
            // return redirect('/reel/'.$this->reel->slug)->with('success','komentar berhasil dibuat');
            $this->reset('body');
        }else {
            return redirect('/reel/'.$this->reel->slug)->with('fail','komentar gagal dibuat.');
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

        if ($comment) {
            $this->reset('body');
            $this->reset('reply_comment_id');
        }else {
            return redirect('/reel/'.$this->reel->slug)->with('fail','komentar gagal diubah.');
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
            $this->edit_comment_id =false;

        }else {
            return redirect('/reel/'.$this->reel->slug)->with('fail','komentar gagal diubah.');
        }

    }

    public function delete($id)
    {
        $comment = CommentModel::where('id',$id)->delete();

        if ($comment) {
            return redirect('/reel/'.$this->reel->slug)->with('success','komentar berhasil dihapus');
        }else {
            return redirect('/reel/'.$this->reel->slug)->with('fail','komentar gagal dihapus.');
        }
    }

    public function like($id)
    {
        $data = [
            'comment_id' => $id,
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
