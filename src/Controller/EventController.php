<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
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
        return $this->render('event/list.html.twig', [
            'controller_name' => 'EventController',
            'events' => $eventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, EventRepository $eventRepository): Response
    {
        $event = new Event();

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->add($event, true);

            // $this->addFlash('success', 'Evènement ajouté');
            return $this->redirectToRoute('app_event_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/create.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    /**
     * @Route ("/{id<\d+>}", name="read", methods={"GET"})
     */
    public function read(Event $event): Response
    {
        return $this->render('event/read.html.twig', [
            'event' => $event,
        ]);
    }

    /**
     * @Route ("/{id<\d+>}/update", name="update", methods={"GET", "POST"})
     */
    public function update(Request $request, Event $event, EventRepository $eventRepo): Response
    {

        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $eventRepo->add($event, true);

            // $this->addFlash('warning', 'Evènement modifié');
            // return $this->redirectToRoute('app_event_list', [], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_event_read', ['id' => $event->getId()]);
        }

        return $this->renderForm('event/update.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $eventRepository->remove($event, true);
        }

        // $this->addFlash('success', 'Evènement supprimé');
        return $this->redirectToRoute('app_event_list', [], Response::HTTP_SEE_OTHER);
    }
}


