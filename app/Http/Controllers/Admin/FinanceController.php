<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Repositories\FinanceRepository;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;

class FinanceController extends Controller
{
  protected $financeRepository;


  public function __construct()
  {
    $this->financeRepository = app(FinanceRepository::class);
  }
  public function finance(){

    $sumOnTekDay = $this->financeRepository->getSumOnToday();

    $sumForMonth = $this->financeRepository->getSumForMonth();

    return view('admin.finance.index', compact('sumOnTekDay', 'sumForMonth'));
  }
}
