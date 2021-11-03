<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;
use NotificationChannels\Telegram\TelegramChannel;

class Telegram extends Notification
{
    use Queueable;
    protected $name;
    protected $phone;
    protected $time;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
  public function __construct($name, $phone, $time)
  {
    $this->name = $name;
    $this->phone = $phone;
    $this->time = $time;
  }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
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
            599738652
        ];
    }

    public function toTelegram($notifiable)
    {
      $arMessage = [
        "https://api.whatsapp.com/send/?phone=7$this->phone&text=Здравствуйте,", "$this->name!\nВы",
        "записаны", "на", "маникюр","$this->time.\nВаш",
        "мастер:", "Белоусова", "Кристина."
      ];
      $textMessage = implode('+',$arMessage);
        return TelegramMessage::create()
          ->content("Новая запись " . $this->name)
          ->button( 'отправить уведомление', $textMessage);


    }
}
