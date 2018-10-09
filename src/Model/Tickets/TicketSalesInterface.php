<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.9
 * Time: 19.56
 */

namespace App\Model\Tickets;


interface TicketSalesInterface
{
    public function getTickets($status, $openingDate, $queryDate, $showDate);
}