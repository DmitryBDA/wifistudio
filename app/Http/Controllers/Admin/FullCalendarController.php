<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class FullCalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar.index');
    }

    public function showEvents()
    {

        header('Content-type: application/json');

        $start = (!empty($_GET["start"])) ? ($_GET["start"]) : ('');
        $end = (!empty($_GET["end"])) ? ($_GET["end"]) : ('');

        $data = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end', 'status', 'allDay']);


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

    public function update(Request $request)
    {
        $where = array('id' => $request->id);
        $updateArr = ['title' => $request->title,'start' => $request->start, 'end' => $request->end];
        $event  = Event::where($where)->update($updateArr);

        return response()->json($event);
    }


    public function actionWithEvents(Request $request)
    {

        switch ($request->type) {

            case 'confirm':
                $event = Event::find($request->id)->update([
                    'status' => 3
                ]);

                return response()->json($event);
                break;


            case 'close':
                $event = Event::find($request->id)->update([
                    'status' => 1,
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


}
