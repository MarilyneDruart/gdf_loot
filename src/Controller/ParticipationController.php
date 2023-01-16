<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Repository\EventRepository;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/event", name="app_event_")
 */
class ParticipationController extends AbstractController
{
    /**
     * @Route("/create-participation", name="create_participation", methods={"GET", "POST"})
     */
    public function create(Request $request, ParticipationRepository $participationRepository, Event $event, EventRepository $eventRepository): Response
    {
        $participation = new Participation();
        $event = $eventRepository->findAll();

        $form = $this->createForm(ParticipationType::class, $participation, array('event' => $event));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participationRepository->add($participation, true);

            // $this->addFlash('success', 'Evènement ajouté');
            return $this->redirectToRoute('app_event_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('event/create_participation.html.twig', [
            'participation' => $participation,
            'form' => $form,
        ]);
    }


}
