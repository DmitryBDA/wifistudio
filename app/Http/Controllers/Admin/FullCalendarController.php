<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\UserEvent;
use Illuminate\Support\Carbon;

class FullCalendarController extends Controller
{
    public function index()
    {
        $tekDate = Carbon::today()->format('Y-m-d');
        $eventList = Event::where('status', '!=', 1)->where('start', '>=', $tekDate)->with('user')->orderBy('start', 'asc')->get();

        $event = new Event;
        //$event = Event::with('user')->find(7);

        return view('admin.calendar.index', compact('event', 'eventList'));
    }

    public function showEvents()
    {

        header('Content-type: application/json');
        $tekDate = Carbon::today()->format('Y-m-d');
        $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
        $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

        $data = Event::whereDate('start', '>=', $tekDate)->whereDate('end',   '<=', $end)->orderBy('start', 'asc')->get(['id','title','start', 'end', 'status', 'allDay']);


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

    public function create(Request $request)
    {

        $insertArr = [ 'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'allDay' => $request->allDay,
            'status' => $request->status
        ];
        $event = Event::insert($insertArr);

        return response()->json($event);
    }

    public function createList(Request $request)
    {

        $arrEvents = $request->dataForm;

        $start = $request->start;
        $end = $request->end;

        foreach ($arrEvents as $Event)
        {
            $title = $Event['value'];

            $insertArr = [ 'title' => $title,
                'start' => $start,
                'end' => $end,
                'allDay' => 1,
                'status' => 1
            ];
            $event = Event::insert($insertArr);

        }

        return response()->json($event);
    }

    public function update(Request $request)
    {
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event  = Event::where($where)->update($updateArr);

        return response()->json($event);
    }

    public function changeTime(Request $request)
    {
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title];
        $event  = Event::where($where)->update($updateArr);

        return response()->json($event);
    }


    public function actionWithEvents(Request $request)
    {

        switch ($request->type) {

            case 'record':
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
                            'status' => 3,
                            'user_id' => $user->id,
                        ];

                    } else {
                        $insertArr = [
                            'name' => $name,
                            'phone' => $phone,
                        ];
                        $newUser = UserEvent::create($insertArr);

                        $dataUpdate = [
                            'status' => 3,
                            'user_id' => $newUser->id,
                        ];
                    }
                } else {
                    $dataUpdate = [
                        'status' => 3,
                    ];
                }

                $event = Event::find($request->id)->update($dataUpdate);

                return response()->json($name);
                break;


            case 'confirm':

                $dataUpdate = [
                    'status' => 3,
                ];

                $event = Event::find($request->id)->update($dataUpdate);

                return response()->json($event);
                break;


            case 'close':
                $event = Event::find($request->id)->update([
                    'status' => 1,
                    'user_id' => null,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = Event::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                # code...
                break;
        }
    }

    public function showModalAction(Request $request){

        $event = Event::with('user')->find($request->idEvent);

        if($request->ajax()){
            return view('admin.calendar.ajax-elem.actionEvents', compact('event'))->render();
        }
    }

    public function copyEvents(){
        $tekDate = Carbon::today()->format('Y-m-d');
        $data = Event::where('status', '=', 1)
            ->whereDate('start','>=', $tekDate)
            ->orderBy('start','asc')
            ->orderBy('title','asc')
            ->get(['id','start', 'title']);
        return response()->json($data);
    }




}
