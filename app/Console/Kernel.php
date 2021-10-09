<?php

namespace App\Console;

use App\Console\Commands\SendReminder;
use App\Models\Event;
use App\Models\UserEvent;
use App\Notifications\Telegram;
use App\Notifications\TelegramSendReminder;
use DateTime;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Jenssegers\Date\Date;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendReminder::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
  /*
        $schedule->call(function () {

            $events = Event::whereDate('updated_at', Carbon::today()->addDay(-21))->get();

            foreach ($events as $event)
            {
                $user = UserEvent::find($event->user_id);

                if($user->telegram_id){

                    Notification::route('telegram', $user->telegram_id)->notify(new Telegram($user->name));
                }
            }
        })->everyMinute();

           */
        $schedule->command('send:reminder')->timezone('Asia/Irkutsk')->dailyAt('10:00');


    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
