<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class AddFollow extends Notification implements ShouldQueue
{
    use Queueable;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['broadcast', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'user' => [
                'name'    => $this->user->name,
                'avatar'  => $this->user->avatar,
                'slug'    => $this->user->slug,
            ],
            'message' => 'đang theo dõi bạn!',
            // 'url' => route('profile.index', ['slug' => $this->user->slug]),
            'created_at' => date('Y-m-d H:m:s')
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'user' => [
                'name'    => $this->user->name,
                'avatar'  => $this->user->avatar,
                'slug'    => $this->user->slug,
            ],
            'message' => 'đang theo dõi bạn!',
            'url' => route('profile.index', ['slug' => $this->user->slug]),
            'created_at' => date('Y-m-d H:m:s')
        ];
    }
}
