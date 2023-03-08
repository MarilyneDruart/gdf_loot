<?php

namespace App\Controller\Back;

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
     * @Route("/admin/", name="app_admin_main")
     */
    public function index(EventRepository $eventRepository, RaidRepository $raidRepository): Response
    {

        // get events from bdd to display on the calendar
        $events = $eventRepository->findAll();
    
        $eventsCalendar = [];
        foreach($events as $event) {
            $raidNames = []; // initialize an empty array to store the names of raids
            foreach ($event->getRaid() as $raid) { // loop through all the raids associated with the event
                $raidNames[] = $raid->getName(); // add the raid name to the array of raid names
            }
            $eventsCalendar[] = [
                'id' => $event->getId(),
                'start' => $event->getStart()->format('Y-m-d H:i:s'),
                'end' => $event->getEnd()->format('Y-m-d H:i:s'),
                'url' => 'https://www.gdf-loot.fr/event/'.$event->getId(),
                'title' => implode(' + ', $raidNames) ?: 'Raid inconnu', // set the raid names as title, or use a default string if no raid is linked
            ];
        };
    
        $data = json_encode($eventsCalendar);
    
        return $this->render('back/main/index.html.twig', compact('data'));
    }
}
