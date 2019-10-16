<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ExpenseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     * @param $expenses
     * @param $user
     * @return void
     */

    protected $expenses;
    protected $user;
    public function __construct($expenses, $user)
    {
        $this->expenses = $expenses;
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
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    // Fungsi untuk menyimpan ke dalam database
    public function toDatabase($notifiable)
    {
        return [
            'sender_id' => $this->user->id,
            'sender_name' => $this->user->user,
            'expenses' => $this->expenses
        ];
    }

    // Fungsi untuk melakukan broadcast
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'sender_id' => $this->user->id,
            'sender_name' => $this->user->user,
            'expenses' => $this->expenses
        ]);
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
            //
        ];
    }
}
