<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.9
 * Time: 20.07
 */

namespace App\Tests\Model\Tickets;


use App\Model\Tickets\ShowTicketSales;
use App\Util\ShowStatusDictionary;
use PHPUnit\Framework\TestCase;

class ShowTicketSalesTest extends TestCase
{
    /**
     * @dataProvider ticketsData
     *
     * @param $openingDate
     * @param $queryDate
     * @param $showDate
     * @param $status
     * @param $expected
     */
    public function testGetTickets($openingDate, $queryDate, $showDate, $status, $expected)
    {
        $ticketSales = new ShowTicketSales();

        $actualTickets = $ticketSales->getTickets($status, $openingDate, $queryDate, $showDate);

        $this->assertEquals($expected, $actualTickets);
    }

    public function ticketsData()
    {
        return [
            ['2018-06-01', '2018-01-01', '2018-07-01', ShowStatusDictionary::STATUS_SALE_NOT_STARTED, [200, 0]],
            ['2018-07-01', '2018-01-01', '2018-07-01', ShowStatusDictionary::STATUS_SALE_NOT_STARTED, [200, 0]],
            ['2018-10-01', '2018-10-01', '2018-10-01', ShowStatusDictionary::STATUS_SOLD_OUT, [0, 0]],
            ['2018-06-01', '2018-08-01', '2018-08-15', ShowStatusDictionary::STATUS_OPEN_FOR_SALE, [50, 5]],
            ['2018-07-01', '2018-08-01', '2018-08-15', ShowStatusDictionary::STATUS_OPEN_FOR_SALE, [100, 10]],
            ['2018-08-01', '2018-08-01', '2018-08-15', ShowStatusDictionary::STATUS_OPEN_FOR_SALE, [100, 10]],
            ['2018-01-01', '2018-05-01', '2018-05-01', ShowStatusDictionary::STATUS_IN_THE_PAST, [0, 0]],
        ];
    }
}