<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 19.26
 */

namespace App\Model;


use App\Util\ShowDatesUtil;
use App\Util\ShowSettings;
use App\Util\ShowStatusDictionary;

class ShowStatusHandler
{
    /**
     * @param $openingDate
     * @param $queryDate
     * @param $showDate
     * @return null|string
     */
    public function getStatus($openingDate, $queryDate, $showDate)
    {
        $startDiff = ShowDatesUtil::getDatesDiff($openingDate, $queryDate);
        $showRunsFor = ShowDatesUtil::getDatesDiff($openingDate, $showDate);
        $daysUntilShow = ShowDatesUtil::getDatesDiff($queryDate, $showDate);

        if ($showRunsFor < 0) {
            return null;
        } elseif ($startDiff < ShowSettings::TICKET_SALE_START) {
            $status = ShowStatusDictionary::STATUS_SALE_NOT_STARTED;
        } elseif ($showRunsFor >= ShowSettings::SHOW_RUNS_FOR) {
            $status = ShowStatusDictionary::STATUS_IN_THE_PAST;
        } elseif ($startDiff >= ShowSettings::TICKET_SALE_START && $daysUntilShow > ShowSettings::SOLD_OUT_BEFORE) {
            $status = ShowStatusDictionary::STATUS_OPEN_FOR_SALE;
        } elseif ($daysUntilShow <= ShowSettings::SOLD_OUT_BEFORE) {
            $status = ShowStatusDictionary::STATUS_SOLD_OUT;
        } else {
            $status = null;
        }

        return $status;
    }
}