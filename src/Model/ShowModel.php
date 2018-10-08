<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 19.26
 */

namespace App\Model;


use App\Util\ShowDictionary;

class ShowModel
{
    private function getDatesDiff($from, $to)
    {
        return (int)date_diff(new \DateTime($from), new \DateTime($to))->format('%r%a');
    }

    public function getStatus($openingDate, $queryDate, $showDate)
    {
        $startDiff = $this->getDatesDiff($openingDate, $queryDate);
        $showRunsFor = $this->getDatesDiff($openingDate, $showDate);
        $daysUntilShow = $this->getDatesDiff($queryDate, $showDate);

        if ($showRunsFor < 0) {
            return null;
        } elseif ($startDiff < ShowDictionary::TICKET_SALE_START) {
            $status = ShowDictionary::STATUS_SALE_NOT_STARTED;
        } elseif ($startDiff >= ShowDictionary::TICKET_SALE_START && $daysUntilShow > ShowDictionary::SOLD_OUT_BEFORE) {
            $status = ShowDictionary::STATUS_OPEN_FOR_SALE;
        } elseif ($showRunsFor >= ShowDictionary::SHOW_RUNS_FOR) {
            $status = ShowDictionary::STATUS_IN_THE_PAST;
        } elseif ($daysUntilShow <= ShowDictionary::SOLD_OUT_BEFORE) {
            $status = ShowDictionary::STATUS_SOLD_OUT;
        } else {
            $status = null;
        }

        return $status;
    }

    public function getTickets($status, $openingDate, $queryDate, $showDate)
    {
        $showRunsFor = $this->getDatesDiff($openingDate, $showDate);

        if (in_array($status, [ShowDictionary::STATUS_SALE_NOT_STARTED, ShowDictionary::STATUS_OPEN_FOR_SALE])) {
            $runsInBigHall = $showRunsFor <= ShowDictionary::BIG_HALL_PERFORMANCES;
            $capacity = $runsInBigHall ? ShowDictionary::BIG_HALL_CAPACITY : ShowDictionary::SMALL_HALL_CAPACITY;
            $available = $runsInBigHall ? ShowDictionary::BIG_HALL_SALES_PER_DAY : ShowDictionary::SMALL_HALL_SALES_PER_DAY;

            if (ShowDictionary::STATUS_SALE_NOT_STARTED === $status) {
                $left = $capacity;
                $available = 0;
            } else {
                $sellingFor = $this->getDatesDiff($queryDate, $showDate) - ShowDictionary::SOLD_OUT_BEFORE + 1;
                $salesPerDay = $available;//"At the end of the day these tickets are per definition sold."
                $left = $capacity - $sellingFor * $salesPerDay;
            }
        } else {
            $available = 0;
            $left = 0;
        }

        return [$left, $available];
    }
}