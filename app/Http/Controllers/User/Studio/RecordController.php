<?php

namespace App\Http\Controllers\User\Studio;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\UserEvent;
use App\Notifications\Sms;
use App\Notifications\Telegram;

use App\Notifications\TelegramSendReminder;
use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Event;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Jenssegers\Date\Date;

class RecordController extends Controller
{
    public function index()
    {
        $event = new Event;
        $services = Service::all();

        return view('user.record', compact('event', 'services'));
    }

    public function showEvents()
    {

        header('Content-type: application/json');
        $tekDate = Carbon::today()->format('Y-m-d');

        $data = Event::whereDate('start', '>=', $tekDate)->where('status', '=', 1)->get(['id','title','start', 'end', 'status', 'allDay']);


        foreach ($data as $elem)
        {
            $tableClassColor = [
                '1' => '#28a745',
                '2' => '#ffc107',
                '3'  => '#dc3545',
            ];

            $elem->setAttr('backgroundColor', $tableClassColor[$elem->status]);
            $elem->setAttr('borderColor', $tableClassColor[$elem->status]);

        }

        return response()->json($data);
    }

    public function showFormRecord(Request $request){

        $event = Event::with('user')->find($request->idEvent);
        $services = Service::all();
        if($request->ajax()){
            return view('user.ajax-elem.formRecord', compact('event', 'services'))->render();
        }
    }

    public function addRecord(Request $request){

        $surname = $request->dataForm[0]['value'];
        $name = $request->dataForm[1]['value'];
        $phone = $request->dataForm[2]['value'];
        $servicesId = $request->dataForm[3]['value'];
        $comment = $request->dataForm[4]['value'];

        if(!empty($name) and !empty($phone)){
            $insertArr = [
                'surname' => $surname,
                'name' => $name,
                'phone' => $phone,
            ];
            $user = UserEvent::select('id', 'name', 'surname', 'phone')->where('phone', $phone)->first();

            if(!empty($user)) {

                $dataUpdate = [
                    'status' => 2,
                    'user_id' => $user->id,
                    'service_id' => $servicesId,
                    'comment' => $comment,
                ];

            } else {
                $insertArr = [
                    'name' => $name,
                    'surname' => $surname,
                    'phone' => $phone,
                ];
                $user = UserEvent::create($insertArr);

                $dataUpdate = [
                    'status' => 2,
                    'user_id' => $user->id,
                    'service_id' => $servicesId,
                    'comment' => $comment,
                ];
            }

            $event = Event::find($request->id);
            $event->update($dataUpdate);
            $name =  $user->surname . ' ' . $user->name;

            $phone = str_replace(['(', ')', '-'], '', $user->phone);
            $phone = substr($phone, 1);
            $name = $user->name;
            $day = Carbon::create($event->start);
            $date = Date::parse($day)->format('l j F');
            $time = str_replace(' ', '+', $date);
            $time .= "+$event->title";

            Notification::route('telegram', config('config_telegram.TELEGRAM_ADMIN_ID'))->notify(new Telegram($name, $phone, $time ));
        }


    }
}
