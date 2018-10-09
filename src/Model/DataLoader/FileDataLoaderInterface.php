<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.9
 * Time: 19.29
 */

namespace App\Model\DataLoader;


interface FileDataLoaderInterface
{
    public function load($filename, $projectDir);
}