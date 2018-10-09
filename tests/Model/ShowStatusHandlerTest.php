<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 19.27
 */

namespace App\Tests\Model;


use App\Model\ShowStatusHandler;
use App\Util\ShowStatusDictionary;
use PHPUnit\Framework\TestCase;

class ShowStatusHandlerTest extends TestCase
{
    /**
     * @dataProvider statusData
     *
     * @param $openingDate
     * @param $queryDate
     * @param $showDate
     * @param $expected
     */
    public function testGetStatus($openingDate, $queryDate, $showDate, $expected)
    {
        $showModel = new ShowStatusHandler();
        $actualStatus = $showModel->getStatus($openingDate, $queryDate, $showDate);

        $this->assertEquals($expected, $actualStatus);
    }

    public function statusData()
    {
        return [
            ['2018-08-01', '2018-01-01', '2018-07-01', null],//invalid
            ['2018-10-01', '2018-10-01', '2018-10-01', ShowStatusDictionary::STATUS_SOLD_OUT],
            ['2018-06-01', '2018-01-01', '2018-07-01', ShowStatusDictionary::STATUS_SALE_NOT_STARTED],
            ['2018-06-01', '2018-08-01', '2018-08-15', ShowStatusDictionary::STATUS_OPEN_FOR_SALE],
            ['2018-07-01', '2018-08-01', '2018-08-15', ShowStatusDictionary::STATUS_OPEN_FOR_SALE],
            ['2018-08-01', '2018-08-01', '2018-08-15', ShowStatusDictionary::STATUS_OPEN_FOR_SALE],
            ['2018-01-01', '2018-05-01', '2018-05-01', ShowStatusDictionary::STATUS_IN_THE_PAST],
            ['2017-10-14', '2018-10-09', '2019-06-20', ShowStatusDictionary::STATUS_IN_THE_PAST],
        ];
    }


}