<?php

namespace App\Http\Controllers\User\Studio;

use App\Http\Controllers\Controller;
use App\Models\UserEvent;
use App\Notifications\Telegram;

use DateTime;
use DateTimeZone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Event;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;

class RecordController extends Controller
{
    public function index()
    {
        $event = new Event;

        return view('user.record', compact('event'));
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

        if($request->ajax()){
            return view('user.ajax-elem.formRecord', compact('event'))->render();
        }
    }

    public function addRecord(Request $request){

        $surname = $request->dataForm[0]['value'];
        $name = $request->dataForm[1]['value'];
        $phone = $request->dataForm[2]['value'];

        if(!empty($name) and !empty($phone)){
            $insertArr = [
                'surname' => $surname,
                'name' => $name,
                'phone' => $phone,
            ];
            $user = UserEvent::select('id')->where('phone', $phone)->first();


            if(!empty($user)) {

                $dataUpdate = [
                    'status' => 2,
                    'user_id' => $user->id,
                ];

            } else {
                $insertArr = [
                    'name' => $name,
                    'surname' => $surname,
                    'phone' => $phone,
                ];
                $newUser = UserEvent::create($insertArr);

                $dataUpdate = [
                    'status' => 2,
                    'user_id' => $newUser->id,
                ];
            }

            $event = Event::find($request->id)->update($dataUpdate);

            Notification::route('telegram', config('config_telegram.TELEGRAM_ADMIN_ID'))->notify(new Telegram($name));
        }


    }
}
