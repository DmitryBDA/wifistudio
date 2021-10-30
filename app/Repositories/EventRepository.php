<?php

namespace App\Repositories;
use App\Models\Event;
use App\Models\Event as Model;
use Illuminate\Support\Carbon;

class EventRepository extends CoreRepository
{

  protected function getModelClass()
  {
    return Model::class;
  }

  /**
   * @return mixed
   */
  public function getActiveRecords()
  {
    $tekDate = Carbon::today()->format('Y-m-d');
    $eventList = $this->startCondition()
      ->where('status', '!=', 1)
      ->where('start', '>=', $tekDate)
      ->with('user')
      ->orderBy('start', 'asc')
      ->get();
    return $eventList;
  }
}
