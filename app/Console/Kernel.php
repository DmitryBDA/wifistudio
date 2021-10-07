<?php

namespace App\Console;

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
        //
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
        $schedule->call(function () {

            $events = Event::whereDate('start', Carbon::today()->addDay(1))->get();

            foreach ($events as $event)
            {
                $user = UserEvent::find($event->user_id);

                if($user){
                    $phone = str_replace(['(', ')', '-'], '', $user->phone);
                    $phone = substr($phone, 1);
                    $name = $user->name;
                    $day = Carbon::today()->addDay(1);
                    $date = Date::parse($day)->format('l j F');
                    $time = str_replace(' ', '+', $date);
                    $time .= "+$event->title";

                    Notification::route('telegram', config('config_telegram.TELEGRAM_ADMIN_ID'))->notify(new TelegramSendReminder($name, $phone, $time));
                }
            }
        })->timezone('Asia/Irkutsk')->dailyAt('10:00');


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
