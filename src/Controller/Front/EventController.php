<?php

namespace App\Controller\Front;

use App\Entity\Event;
use App\Entity\LootHistory;
use App\Entity\Participation;
use App\Form\EventType;
use App\Form\LootHistoryType;
use App\Form\ParticipationType;
use App\Repository\EventRepository;
use App\Repository\LootHistoryRepository;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/event", name="app_event_")
 */
class EventController extends AbstractController
{

    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(EventRepository $eventRepository): Response
    {
        return $this->render('front/event/list.html.twig', [
            'controller_name' => 'EventController',
            'events' => $eventRepository->findAll(),
        ]);
    }

    /**
     * @Route ("/{id<\d+>}", name="read", methods={"GET"})
     */
    public function read(Event $event, Participation $participation, EventRepository $eventRepository): Response
    {
        $previousEvent = $eventRepository->findPreviousEvent($event);
        $nextEvent = $eventRepository->findNextEvent($event);

        return $this->render('front/event/read.html.twig', [
            'event' => $event,
            'participation' => $participation,
            'previous_event' => $previousEvent,
            'next_event' => $nextEvent,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/previous", name="read_previous")
     */
    public function readPrevious(Event $event, EventRepository $eventRepository)
    {
        $previousEvent = $eventRepository->findPreviousEvent($event);

        return $this->redirectToRoute('app_event_read', ['id' => $previousEvent->getId()]);
    }

    /**
     * @Route("/{id<\d+>}/next", name="read_next")
     */
    public function readNext(Event $event, EventRepository $eventRepository)
    {
        $nextEvent = $eventRepository->findNextEvent($event);

        return $this->redirectToRoute('app_event_read', ['id' => $nextEvent->getId()]);
    } 
}


