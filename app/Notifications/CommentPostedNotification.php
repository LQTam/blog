<?php

namespace App\Notifications;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class CommentPostedNotification extends Notification
{
    use Queueable;
    /**
     * @var Post
     */
    public $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toDatabase($notifiable)
    {
        return [
            'post' => $this->post,
            'user' => auth()->user(),
        ];
    }

    public function toBroadcast($notifiable){
        return new BroadcastMessage([
            'post' => $this->post,
            'user' => auth()->user(),
        ]);
    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toArray($notifiable)
    // {
    //     return [
    //         'comment' => $this->comment,
    //         // 'user' => auth()->user(),
    //     ];
    // }
}
