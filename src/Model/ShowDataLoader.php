<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 21.11
 */

namespace App\Model;


class ShowDataLoader
{
    const UPLOADS_DIR = "uploads";

    public function load($filename)
    {
        $file = file(self::UPLOADS_DIR . DIRECTORY_SEPARATOR . $filename, FILE_SKIP_EMPTY_LINES);
        $csv = array_map("str_getcsv", $file);
        $keys = ['title', 'opening', 'genre'];
        $inventory = [];

        foreach ($csv as $row) {
            $show = array_combine($keys, $row);
            $inventory[] = $show;
        }

        return $inventory;
    }

}