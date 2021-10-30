<?php

namespace App\Repositories;
use App\Models\Service as Model;

class ServiceRepository extends CoreRepository
{

  protected function getModelClass()
  {
    return Model::class;
  }

  public function getAll(){

    $services = $this->startCondition()
      ->all();

    return $services;
  }

}
