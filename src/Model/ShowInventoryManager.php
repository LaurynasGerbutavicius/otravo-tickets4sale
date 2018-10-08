<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 21.27
 */

namespace App\Model;


class ShowInventoryManager
{
    private $model;
    private $pricingHandler;

    public function __construct(ShowModel $model, ShowPricingHandler $pricingHandler)
    {
        $this->model = $model;
        $this->pricingHandler = $pricingHandler;
    }

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

    private function getInventoryItem($show, $queryDate, $showDate, $showPrice)
    {
        $openingDate = $show['opening'];
        $showStatus = $this->model->getStatus($openingDate, $queryDate, $showDate);

        if (null === $showStatus) {
            return null;
        }

        list ($ticketsLeft, $ticketsAvailable) = $this->model
            ->getTickets($showStatus, $openingDate, $queryDate, $showDate);

        $item = [
            'title' => $show['title'],
            'tickets_left' => $ticketsLeft,
            'tickets_available' => $ticketsAvailable,
            'status' => $showStatus
        ];

        if ($showPrice) {
            $item['price'] = $this->pricingHandler
                ->getPrice($show['genre'], $this->model->getDatesDiff($openingDate, $showDate));
        }

        return $item;
    }
}