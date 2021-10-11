<?php

namespace App\Console\Commands;

use App\Notifications\Telegram;
use App\Notifications\TelegramRecordingNotification;
use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\UserEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Carbon;
use Jenssegers\Date\Date;

class GetRecordingNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:record';

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
        $events = Event::whereDate('start', Carbon::today()->addDay(-21))->get();

        foreach ($events as $event) {
            $user = UserEvent::find($event->user_id);

            if ($user) {

                $nextEvent = Event::whereDate('start', '>', Carbon::today()->addDay(-21))->where('user_id', $user->id)->get();

                if ($nextEvent->isEmpty()) {
                    $phone = str_replace(['(', ')', '-'], '', $user->phone);
                    $phone = substr($phone, 1);
                    $name = $user->name;

                    Notification::route('telegram', config('config_telegram.TELEGRAM_ADMIN_ID'))->notify(new TelegramRecordingNotification($name, $phone));
                }
            }
        }
    }
}
