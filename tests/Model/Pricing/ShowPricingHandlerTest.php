<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.9
 * Time: 20.06
 */

namespace App\Tests\Model\Pricing;


use App\Model\Pricing\ShowPricingHandler;
use PHPUnit\Framework\TestCase;

class ShowPricingHandlerTest extends TestCase
{
    /**
     * @dataProvider data
     *
     * @param $genre
     * @param $nthShow
     * @param $expected
     */
    public function testGetPrice($genre, $nthShow, $expected)
    {
        $handler = new ShowPricingHandler();
        $actual = $handler->getPrice($genre, $nthShow);
        $this->assertEquals($expected, $actual);
    }

    public function data()
    {
        return [
            ['drama', 1, 40],
            ['drama', 60, 40],
            ['drama', 61, 40 * 0.8],
            ['musical', 2, 70],
            ['comedy', 2, 50]
        ];
    }
}