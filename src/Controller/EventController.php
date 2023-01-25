<?php

namespace App\Controller;

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
    public function read(Event $event, Participation $participation): Response
    {
        return $this->render('event/read.html.twig', [
            'event' => $event,
            'participation' => $participation,
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

    /**
     * add participation in event (id of event)
     *
     * @Route("/{id<\d+>}/participation/add", name="participation_create", methods={"GET", "POST"})
     * @return Response
     */
    public function participationCreate(EntityManagerInterface $em, Event $event, Request $request) :Response
    {
        $participation = new Participation();

        $participation->setEvent($event);
        $form = $this->createForm(ParticipationType::class, $participation);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {
            // ? Traiter le formulaire
            // entitymanager ( cf paramètre, ParamConverter)
            // persist
            $em->persist($participation);

            //flush
            $em->flush();

            // // ? Ajouter un flash message
            // $this->addFlash('success', 'participation ajoutée');

            // ? Rediriger l'utilisateur
            return $this->redirectToRoute('app_event_read', ['id' => $event->getId()]);

        }

        return $this->render('event/_participation_create.html.twig', [
            'form' => $form->createView(),
            'event' => $event,
        ]);
    }

    /**
     * delete participation in event (id of participation)
     *
     * @Route("/{id<\d+>}/participation/delete", name="participation_delete", methods={"GET", "POST"})
     * @return Response
     */
    public function participationDelete(Request $request, Event $event, ParticipationRepository $participationRepository, Participation $participation) :Response
    {
        if ($this->isCsrfTokenValid('delete'.$participation->getId(), $request->request->get('_token'))) {
            $participationRepository->remove($participation, true);
        }

        // $this->addFlash('success', 'Participation supprimée');
        return $this->redirectToRoute('app_event_read', ['id' => $event->getId()]);
    }

    /**
     * add lootHistory in event (id of event)
     *
     * @Route("/{id<\d+>}/loothistory/add", name="lootHistory_create", methods={"GET", "POST"})
     * @return Response
     */
    public function lootHistoryCreate(EntityManagerInterface $em, Event $event, Request $request) :Response
    {
        $lootHistory = new LootHistory();

        $lootHistory->setEvent($event);
        $form = $this->createForm(LootHistoryType::class, $lootHistory);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {
            // ? Traiter le formulaire
            // entitymanager ( cf paramètre, ParamConverter)
            // persist
            $em->persist($lootHistory);

            //flush
            $em->flush();

            // // ? Ajouter un flash message
            // $this->addFlash('success', 'item looté ajouté');

            // ? Rediriger l'utilisateur
            return $this->redirectToRoute('app_event_read', ['id' => $event->getId()]);

        }

        return $this->render('event/_lootHistory_create.html.twig', [
            'form' => $form->createView(),
            'event' => $event,
        ]);
    }
    
    /**
     * delete lootHistory in event (id of lootHistory)
     *
     * @Route("/{id<\d+>}/lootHistory/delete", name="lootHistory_delete", methods={"GET", "POST"})
     * @return Response
     */
    public function lootHistoryDelete(Request $request, Event $event, LootHistoryRepository $lootHistoryRepository, LootHistory $lootHistory) :Response
    {
        if ($this->isCsrfTokenValid('delete'.$lootHistory->getId(), $request->request->get('_token'))) {
            $lootHistoryRepository->remove($lootHistory, true);
        }

        // $this->addFlash('success', 'Item supprimé');
        return $this->redirectToRoute('app_event_read', ['id' => $event->getId()]);
    }
}


