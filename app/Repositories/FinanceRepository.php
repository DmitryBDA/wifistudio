<?php

namespace App\Repositories;
use App\Models\Event;
use App\Models\Event as Model;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Carbon;

class FinanceRepository extends CoreRepository
{


  protected function getModelClass()
  {
    return Model::class;
  }

  public function getSumOnToday(){
    $today =  new DateTime('now', new DateTimeZone('Asia/Irkutsk'));


    $tekDate = $today->format('Y-m-d');
    $tekTime = $today->format('H');
    $firstDay = date('Y-m-01');
    $lastDay = date('Y-m-t');


    $events = $this->startCondition()
      ->with('service')
      ->where('start','<', $tekDate)
      ->where('status', '!=', 1)
      ->where('start', '>=', $firstDay)
      ->get();

    $event = $this->startCondition()
      ->with('service')
      ->where('start',$tekDate)
      ->where('status', '!=', 1)
      ->where('title', '<=', "$tekTime:00")
      ->get();

    $events = $events->merge($event);

    $sumOnTekDay = 0;
    foreach ($events as $event){
      if($event->service){
        $sumOnTekDay += $event->service->price;
      }
    }
    return $sumOnTekDay;
  }

  public function getSumForMonth(){
    $firstDay = date('Y-m-01');
    $lastDay = date('Y-m-t');


    $events = $this->startCondition()
      ->with('service')
      ->where('start','>=', $firstDay)
      ->where('status', '!=', 1)
      ->where('start', '<=', $lastDay)
      ->get();

    $sumFomMonth = 0;
    foreach ($events as $event){
      if($event->service){
        $sumFomMonth += $event->service->price;
      }
    }
    return $sumFomMonth;
  }

}
