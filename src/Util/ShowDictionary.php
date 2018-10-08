<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 20.58
 */

namespace App\Util;


class ShowDictionary
{
    const TICKET_SALE_START = -25;
    const SOLD_OUT_BEFORE = 5;
    const SHOW_RUNS_FOR = 100;

    const STATUS_SALE_NOT_STARTED = "sale not started";
    const STATUS_OPEN_FOR_SALE = "open for sale";
    const STATUS_SOLD_OUT = "sold out";
    const STATUS_IN_THE_PAST = "in the past";

    const BIG_HALL_PERFORMANCES = 60;
    const BIG_HALL_CAPACITY = 200;
    const SMALL_HALL_CAPACITY = 100;

    const BIG_HALL_SALES_PER_DAY = 10;
    const SMALL_HALL_SALES_PER_DAY = 5;
}