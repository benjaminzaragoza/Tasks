<?php

namespace App\Notifications;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class TaskUncompleted extends Notification{
    use Queueable;

    public $task;

    /**
     * Create a new notification instance.
     *
     * @param $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', WebPushChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => "S'ha descompletat la tasca: " . $this->task->name,
            'url' => '/tasques/' . $this->task->id,
            'icon' => 'assignment',
            'iconColor' => 'primary',
            'task' => $this->task->map()
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Tasca descompletada!')
            ->icon('/notification-icon.png')
            ->body('Has descompletat la tasca: ' . $this->task->name)
            ->action('Visualitza la tasca', 'open_url')
            ->data(['url' => env('APP_URL') . '/tasques/' . $this->task->id]);
    }
}
