<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.9
 * Time: 19.58
 */

namespace App\Util;


class ShowDatesUtil
{
    /**
     * @param $from
     * @param $to
     * @return int
     */
    public static function getDatesDiff($from, $to)
    {
        return (int)date_diff(new \DateTime($from), new \DateTime($to))->format('%r%a');
    }
}