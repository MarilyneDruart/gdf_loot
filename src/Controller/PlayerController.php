<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/player", name="app_player_")
 */
class PlayerController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(PlayerRepository $playerRepository): Response
    {
        $rankSerieux = $playerRepository->findPlayerByRank('Sérieux');
        $rankDemi = $playerRepository->findPlayerByRank('Demi');
        $rankGalopin = $playerRepository->findPlayerByRank('Galopin');
        // dump($ranks); die;

        return $this->render('player/list.html.twig', [
            'controller_name' => 'PlayerController',
            'players' => $playerRepository->findAll(),
            'rankSerieux' => $rankSerieux,
            'rankDemi' => $rankDemi,
            'rankGalopin' => $rankGalopin,
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, PlayerRepository $playerRepository): Response
    {
        $player = new Player();

        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $playerRepository->add($player, true);

            $this->addFlash('success', 'Joueur ajouté');
            return $this->redirectToRoute('app_player_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('player/create.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }

    /**
     * @Route ("/{id<\d+>}", name="read", methods={"GET"}, requirements={"id"="\d+"})
     * @Route ("/{slug}", name="show_by_slug", methods={"GET"})
     */
    public function read(Player $player, PlayerRepository $playerRepository): Response
    {
        return $this->render('player/read.html.twig', [
            'player' => $player,
            'players' => $playerRepository->findAll(),
        ]);
    }

    /**
     * @Route ("/{id<\d+>}/update", name="update", methods={"GET", "POST"})
     */
    public function update(Request $request, Player $player, PlayerRepository $playerRepository): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $playerRepository->add($player, true);

            $this->addFlash('warning', 'Joueur modifié');
            return $this->redirectToRoute('app_player_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('player/update.html.twig', [
            'player' => $player,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Player $event, PlayerRepository $eventRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $eventRepository->remove($event, true);
        }

        $this->addFlash('success', 'Joueur supprimé');
        return $this->redirectToRoute('app_player_list', [], Response::HTTP_SEE_OTHER);
    }
}
