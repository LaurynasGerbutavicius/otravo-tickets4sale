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

    public function __construct(ShowModel $model)
    {
        $this->model = $model;
    }

    public function getInventory($shows, $queryDate, $showDate)
    {
        $inventory = [];

        foreach ($shows as $show) {
            $inventoryItem = $this->getInventoryItem($show, $queryDate, $showDate);

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

    private function getInventoryItem($show, $queryDate, $showDate)
    {
        $openingDate = $show['opening'];
        $showStatus = $this->model->getStatus($openingDate, $queryDate, $showDate);

        if (null === $showStatus) {
            return null;
        }

        list ($ticketsLeft, $ticketsAvailable) = $this->model
            ->getTickets($showStatus, $openingDate, $queryDate, $showDate);

        return [
            'title' => $show['title'],
            'tickets_left' => $ticketsLeft,
            'tickets_available' => $ticketsAvailable,
            'status' => $showStatus
        ];
    }
}