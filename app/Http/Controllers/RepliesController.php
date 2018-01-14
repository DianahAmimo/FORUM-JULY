<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Thread;
use App\User;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * @param $channelId
     * @param Thread $thread
     * @param CreatePostRequest $form
     * @return \Illuminate\Http\RedirectResponse
     * @internal param \App\Inspections\Spam $spam
     */
    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {
        if ($thread->locked) {
            return response('Thread is locked', 422);
        }

        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
     }

     public function update(Reply $reply)
     {
         $this->authorize('update', $reply);

         $this->validate(request(), ['body' => 'required|spamfree']);

         $reply->update(request(['body']));
     }

     public function destroy(Reply $reply)
     {
         $this->authorize('update', $reply);

         $reply->delete();

         if (request()->expectsJson()) {
             return response(['status' => 'Reply deleted']);
         }

         return back();
     }
}
