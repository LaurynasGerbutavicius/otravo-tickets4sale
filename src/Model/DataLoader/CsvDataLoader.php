<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 21.11
 */

namespace App\Model\DataLoader;


class CsvDataLoader implements FileDataLoaderInterface
{
    const UPLOADS_DIR = "uploads";

    /**
     * @param $filename
     * @param $projectDir
     * @return array
     */
    public function load($filename, $projectDir)
    {
        $file = file($projectDir . self::UPLOADS_DIR . DIRECTORY_SEPARATOR . $filename, FILE_SKIP_EMPTY_LINES);
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