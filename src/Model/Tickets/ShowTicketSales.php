<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.9
 * Time: 19.57
 */

namespace App\Model\Tickets;


use App\Util\ShowDatesUtil;
use App\Util\ShowSettings;
use App\Util\ShowStatusDictionary;

class ShowTicketSales implements TicketSalesInterface
{
    /**
     * @param $status
     * @param $openingDate
     * @param $queryDate
     * @param $showDate
     * @return array
     */
    public function getTickets($status, $openingDate, $queryDate, $showDate)
    {
        $showRunsFor = ShowDatesUtil::getDatesDiff($openingDate, $showDate);

        if (in_array($status, [ShowStatusDictionary::STATUS_SALE_NOT_STARTED, ShowStatusDictionary::STATUS_OPEN_FOR_SALE])) {
            $runsInBigHall = $showRunsFor <= ShowSettings::BIG_HALL_PERFORMANCES;
            $capacity = $runsInBigHall ? ShowSettings::BIG_HALL_CAPACITY : ShowSettings::SMALL_HALL_CAPACITY;
            $available = $runsInBigHall ? ShowSettings::BIG_HALL_SALES_PER_DAY : ShowSettings::SMALL_HALL_SALES_PER_DAY;

            if (ShowStatusDictionary::STATUS_SALE_NOT_STARTED === $status) {
                $left = $capacity;
                $available = 0;
            } else {
                $sellingFor = ShowDatesUtil::getDatesDiff($queryDate, $showDate) - ShowSettings::SOLD_OUT_BEFORE + 1;
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