<?php

namespace App\Console\Commands;

use App\Download;
use App\MonthlyAggregate;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $months = $this->getMonths();
        foreach ($months as $period) {
            $downloads = $this->getDownloadsByMonthAndYear($period['month'], $period['year']);
            dd($period,$downloads);
            $this->saveAggregate($period['month'].'-'.$period['year'], $downloads);
        }
    }

    private function getDownloadsByMonthAndYear($month, $year): int
    {
        $max = Download::where('box_id', 1)->where('created_at', 'LIKE', $year.'%'.$month.'%')->max('downloads');
        $min = Download::where('box_id', 1)->where('created_at', 'LIKE', $year.'%'.$month.'%')->min('downloads');

        return $max - $min;
    }

    private function saveAggregate($label, $data)
    {
        return MonthlyAggregate::create(['label' => $label, 'data' => $data]);
    }

    private function getMonths()
    {
        $start    = new DateTime('2020-09-01');
        $end      = new DateTime();
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);
        $data = [];

        foreach ($period as $dt) {
            $data_month = [
                'month' => $dt->format("m"),
                'year' => $dt->format("Y")
            ];
            array_push($data, $data_month);
        }

        return $data;
    }

}
