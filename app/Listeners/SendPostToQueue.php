<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Contracts\Queue\ShouldQueue; // Import this
use Illuminate\Queue\InteractsWithQueue;

class SendPostToQueue implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(PostCreated $event): void
    {
        $post = $event->post;

        // Process the post, e.g., push to Beanstalk queue, log, etc.
        \Log::info("Post queued: " . $post->title);
    }
}
