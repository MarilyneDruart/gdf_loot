<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\ItemRepository;
use App\Repository\PlayerRepository;
use App\Repository\RaidRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main")
     */
    public function index(EventRepository $eventRepository, RaidRepository $raidRepository): Response
    {

        // get events from bdd to display on the calendar
        $events = $eventRepository->findAll();
        $raid = $raidRepository->findAll();



        $directory = $this->getParameter('kernel.project_dir');

        $eventsCalendar = [];
        foreach($events as $event) {
            
            // je dois récupérer le nom du ou des raids rattachés à un event
            // event contient un ou plusieurs raids
            // raid contient un name
            $raids = [];
            $raids[] = [
                $event->getRaid(),
            ];

            $raidsName = [];
            foreach($event as $raids) {
                $raidsName[] = [
                    $raidsName = $raids->getName(),
                ];
            }
            dd($raidsName);die;

            
            $eventsCalendar[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                
                //TODO URL and TITLE
                // 'url' => $directory.'/'.'event'.'/'.$event->getId(),
                'url' => 'http://localhost:8000/event/'.$event->getId(),
                'title' => $raidsName,
            ];
        };

        $data = json_encode($eventsCalendar);

        return $this->render('main/index.html.twig', 
        compact('data'), 
    );
    }
}
