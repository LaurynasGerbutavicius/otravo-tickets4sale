<?php
/**
 * Created by PhpStorm.
 * User: laurynas
 * Date: 18.10.8
 * Time: 22.28
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class ShowController extends Controller
{
    /**
     * @Route("/", name="index")
     * @param Request $request
     * @param KernelInterface $kernel
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function index(Request $request, KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $defaultFilename = "shows.csv";

        if ($request->request->has('show_date')) {
            $showDate = $request->request->get('show_date');
        } else {
            $showDate = date('Y-m-d');
        }

        $input = new ArrayInput(array(
            'command' => 'app:list_shows',
            'filename' => $defaultFilename,
            'query_date' => date('Y-m-d'),
            'show_date' => $showDate,
            'project_dir' => $kernel->getRootDir() . "/../",
            'show_price' => true
        ));

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();

        $data = json_decode($content, true);

        return $this->render('shows.html.twig', [
            'list' => $data['inventory'],
            'show_date' => $showDate
        ]);
    }
}