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

        $data = Event::whereDate('start', '>=', $start)->whereDate('end',   '<=', $end)->get(['id','title','start', 'end', 'borderColor', 'backgroundColor', 'allDay']);


        return response()->json($data);
    }

    public function create(Request $request)
    {
        $insertArr = [ 'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end
        ];
        $event = Event::insert($insertArr);
        return response()->json($event);
    }
}
