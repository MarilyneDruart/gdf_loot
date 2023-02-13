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
            $eventsCalendar[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                
                //TODO URL and TITLE
                // 'url' => $directory.'/'.'event'.'/'.$event->getId(),
                'url' => 'http://localhost:8000/event/'.$event->getId(),
                // 'title' => $event->getRaid(['']),
            ];
        }
        $data = json_encode($eventsCalendar);

        return $this->render('main/index.html.twig', 
        compact('data'), 
    );
    }
}
