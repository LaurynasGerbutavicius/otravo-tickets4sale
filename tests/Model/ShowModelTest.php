<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 19.27
 */

namespace App\Tests\Model;


use App\Model\ShowModel;
use App\Util\ShowDictionary;
use PHPUnit\Framework\TestCase;

class ShowModelTest extends TestCase
{
    /**
     * @dataProvider statusData
     *
     * @param $opening
     * @param $query
     * @param $show
     * @param $expected
     */
    public function testGetStatus($opening, $query, $show, $expected)
    {
        $showModel = new ShowModel();
        $actualStatus = $showModel->getStatus($opening, $query, $show);

        $this->assertEquals($expected, $actualStatus);
    }

    public function statusData()
    {
        return [
            ['2018-08-01', '2018-01-01', '2018-07-01', null],//invalid
            ['2018-10-01', '2018-10-01', '2018-10-01', ShowDictionary::STATUS_SOLD_OUT],
            ['2018-06-01', '2018-01-01', '2018-07-01', ShowDictionary::STATUS_SALE_NOT_STARTED],
            ['2018-06-01', '2018-08-01', '2018-08-15', ShowDictionary::STATUS_OPEN_FOR_SALE],
            ['2018-07-01', '2018-08-01', '2018-08-15', ShowDictionary::STATUS_OPEN_FOR_SALE],
            ['2018-08-01', '2018-08-01', '2018-08-15', ShowDictionary::STATUS_OPEN_FOR_SALE],
            ['2018-01-01', '2018-05-01', '2018-05-01', ShowDictionary::STATUS_IN_THE_PAST],
        ];
    }

    /**
     * @dataProvider ticketsData
     *
     * @param $status
     * @param $opening
     * @param $query
     * @param $show
     * @param $expected
     */
    public function testGetTickets($opening, $query, $show, $status, $expected)
    {
        $showModel = new ShowModel();

        $actualTickets = $showModel->getTickets($status, $opening, $query, $show);

        $this->assertEquals($expected, $actualTickets);
    }

    public function ticketsData()
    {
        return [
            ['2018-06-01', '2018-01-01', '2018-07-01', ShowDictionary::STATUS_SALE_NOT_STARTED, [200, 0]],
            ['2018-07-01', '2018-01-01', '2018-07-01', ShowDictionary::STATUS_SALE_NOT_STARTED, [200, 0]],
            ['2018-10-01', '2018-10-01', '2018-10-01', ShowDictionary::STATUS_SOLD_OUT, [0, 0]],
            ['2018-06-01', '2018-08-01', '2018-08-15', ShowDictionary::STATUS_OPEN_FOR_SALE, [50, 5]],
            ['2018-07-01', '2018-08-01', '2018-08-15', ShowDictionary::STATUS_OPEN_FOR_SALE, [100, 10]],
            ['2018-08-01', '2018-08-01', '2018-08-15', ShowDictionary::STATUS_OPEN_FOR_SALE, [100, 10]],
            ['2018-01-01', '2018-05-01', '2018-05-01', ShowDictionary::STATUS_IN_THE_PAST, [0, 0]],
        ];
    }
}