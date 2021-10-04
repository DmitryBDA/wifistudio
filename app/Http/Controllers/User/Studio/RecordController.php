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

        $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
        $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

        $data = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->where('status', '=', 1)->get(['id','title','start', 'end', 'status', 'allDay']);


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

        $name = $request->dataForm[0]['value'];
        $phone = $request->dataForm[1]['value'];

        if(!empty($name) and !empty($phone)){
            $insertArr = [
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
                    'phone' => $phone,
                ];
                $newUser = UserEvent::create($insertArr);

                $dataUpdate = [
                    'status' => 2,
                    'user_id' => $newUser->id,
                ];
            }

            $event = Event::find($request->id)->update($dataUpdate);

            Notification::route('telegram', '599738652')->notify(new Telegram);
        }


    }
}
