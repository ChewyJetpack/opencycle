<?php

namespace Opencycle\Listeners;

use Opencycle\Events\PostCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Opencycle\Notifications\NewPost;

class SendNewPostNotifications
{
    /**
     * Handle the event.
     *
     * @param  PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        $post = $event->post;

        $post->group->users->filter(function (User $user) use ($post) {
            return $user->id !== $post->user->id;
        })->each(function (User $user) use ($post) {
            $user->notify(new NewPost($post)); // TODO: User notification settings
        });
    }
}
