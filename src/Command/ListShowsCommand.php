<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.7
 * Time: 22.14
 */

namespace App\Command;


use App\Model\ShowDataLoader;
use App\Model\ShowInventoryManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListShowsCommand extends Command
{
    private $dataLoader;
    private $manager;

    public function __construct(ShowDataLoader $dataLoader, ShowInventoryManager $manager)
    {
        $this->dataLoader = $dataLoader;
        $this->manager = $manager;
        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setName('app:list_shows')
            ->setDescription('List shows from input file by query date and show date');

        $this
            ->addArgument('filename', InputArgument::REQUIRED, 'Filename to import')
            ->addArgument('query_date', InputArgument::REQUIRED, 'Query date')
            ->addArgument('show_date', InputArgument::REQUIRED, 'Show date');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filename = $input->getArgument('filename');
        $queryDate = $input->getArgument('query_date');
        $showDate = $input->getArgument('show_date');

        $shows = $this->dataLoader->load($filename);
        $inventory = $this->manager->getInventory($shows, $queryDate, $showDate);
        $data = ['inventory' => $inventory];

        $output->writeln(json_encode($data));
    }

}