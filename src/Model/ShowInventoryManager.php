<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 21.27
 */

namespace App\Model;


use App\Model\Pricing\PricingHandlerInterface;
use App\Model\Tickets\TicketSalesInterface;
use App\Util\ShowDatesUtil;

class ShowInventoryManager
{
    private $statusHandler;
    private $pricingHandler;
    private $ticketSales;

    public function __construct(
        ShowStatusHandler $statusHandler,
        PricingHandlerInterface $pricingHandler,
        TicketSalesInterface $ticketSales
    )
    {
        $this->statusHandler = $statusHandler;
        $this->pricingHandler = $pricingHandler;
        $this->ticketSales = $ticketSales;
    }

    /**
     * @param $shows
     * @param $queryDate
     * @param $showDate
     * @param bool $showPrice
     * @return array
     */
    public function getInventory($shows, $queryDate, $showDate, $showPrice = false)
    {
        $inventory = [];

        foreach ($shows as $show) {
            $inventoryItem = $this->getInventoryItem($show, $queryDate, $showDate, $showPrice);

            if (null === $inventoryItem) {
                continue;
            }

            $genre = $show['genre'];

            if (!isset($inventory[$genre])) {
                $inventory[$genre] = [
                    'genre' => $genre,
                    'shows' => []
                ];
            }

            $inventory[$genre]['shows'][] = $inventoryItem;
        }

        return $inventory;
    }

    /**
     * @param $show
     * @param $queryDate
     * @param $showDate
     * @param $showPrice
     * @return array|null
     */
    private function getInventoryItem($show, $queryDate, $showDate, $showPrice)
    {
        $openingDate = $show['opening'];
        $showStatus = $this->statusHandler->getStatus($openingDate, $queryDate, $showDate);

        if (null === $showStatus) {
            return null;
        }

        list ($ticketsLeft, $ticketsAvailable) = $this->ticketSales
            ->getTickets($showStatus, $openingDate, $queryDate, $showDate);

        $item = [
            'title' => $show['title'],
            'tickets_left' => $ticketsLeft,
            'tickets_available' => $ticketsAvailable,
            'status' => $showStatus
        ];

        if ($showPrice) {
            $item['price'] = $this->pricingHandler
                ->getPrice($show['genre'], ShowDatesUtil::getDatesDiff($openingDate, $showDate));
        }

        return $item;
    }
}