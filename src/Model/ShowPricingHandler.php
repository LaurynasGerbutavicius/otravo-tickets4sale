<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 23.12
 */

namespace App\Model;


class ShowPricingHandler
{
    private $priceMap = [
        'musical' => 70,
        'comedy' => 50,
        'drama' => 40
    ];

    const DISCOUNT_AFTER_SHOWS = 60;
    const DISCOUNT_COEFFICIENT = 0.8;

    public function getPrice($genre, $nthShow)
    {
        $price = $this->priceMap[trim(strtolower($genre))];
        if ($nthShow > self::DISCOUNT_AFTER_SHOWS) {
            $price *= self::DISCOUNT_COEFFICIENT;
        }

        return $price;
    }
}