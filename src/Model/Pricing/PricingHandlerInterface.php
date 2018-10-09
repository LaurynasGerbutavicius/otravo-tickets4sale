<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.9
 * Time: 19.35
 */

namespace App\Model\Pricing;


interface PricingHandlerInterface
{
    public function getPrice($genre, $nthShow);
}