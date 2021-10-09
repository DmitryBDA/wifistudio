<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\UserEvent;
use App\Notifications\TelegramSendReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Jenssegers\Date\Date;

class SendReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $events = Event::whereDate('start', Carbon::today()->addDay(1))->get();

        foreach ($events as $event) {
            $user = UserEvent::find($event->user_id);

            if ($user) {
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
    }

}
