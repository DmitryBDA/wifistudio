<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramRecordingNotification extends Notification
{
    use Queueable;
    protected $nameUser;
    protected $phone;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $phone)
    {
        $this->nameUser = $name;
        $this->phone = $phone;
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
    public function toTelegram($notifiable)
    {
        $arMessage = [
          "https://api.whatsapp.com/send/?phone=7$this->phone&text=Добрый","день,", "$this->nameUser!\nНапоминаю,",
          "что", "подошел", "срок","записи", "на", "маникюр.\nЗаписаться",
          "вы", "можете", "по", "ссылке,", "выбрав", "удобную", "дату","и",
          "время.\nhttps://www.bykristy.site/record\nВаш",
          "мастер:", "Белоусова", "Кристина."
        ];
        $textMessage = implode('+',$arMessage);
        return TelegramMessage::create()
            ->button($this->nameUser, $textMessage)
            ->content("Напомнить клиенту о корекции");
    }
}
