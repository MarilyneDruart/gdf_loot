<?php

namespace App\Controller;

use App\Entity\Player;
use App\Form\PlayerType;
use App\Utils\MySlugger;
use App\Repository\PlayerRepository;
use App\Repository\LootHistoryRepository;
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
        $ranks = $playerRepository->findPlayerByRank();
        $roles = $playerRepository->findPlayerByRole();
        $participations = $playerRepository->findPlayerByParticipation();
        $benchs = $playerRepository->findPlayerByBench();
    
        //dd($lootHistoriesBis); die;

        return $this->render('player/list.html.twig', [
            'controller_name' => 'PlayerController',
            'players' => $playerRepository->findAll(),
            'ranks' => $ranks,
            'roles' => $roles,
            'participations' => $participations,
            'benchs' => $benchs,
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, PlayerRepository $playerRepository, MySlugger $mySlugger): Response
    {
        $player = new Player();

        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $player->setSlug($mySlugger->slugify($player->getName()));
            $playerRepository->add($player, true);

            // $this->addFlash('success', 'Joueur ajouté');
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
    public function read(Player $player, PlayerRepository $playerRepository, LootHistoryRepository $lootHistoryRepository, string $slug): Response
    {

        $lootHistories = $lootHistoryRepository->findLootHistory($slug);
        $nbPresences = $lootHistoryRepository->findNbPresence($slug);
        $nbBenches = $lootHistoryRepository->findNbBench($slug);
        $nbItemBis = $lootHistoryRepository->findNbItemBis($slug);
        $nbItemContested = $lootHistoryRepository->findNbItemContested($slug);

        $scoreContested = $nbItemContested[0]['nombre'] * 2;
        $scoreBis = $nbItemBis[0]['nombre'];
        if ($nbBenches[0]['nombre'] == 0 && $nbPresences[0]['nombre'] == 0)
        {
            $scorePresence = 1;
        } else {
            $scorePresence = $nbBenches[0]['nombre'] + $nbPresences[0]['nombre'];
        }

        $scores = ($scoreContested + $scoreBis) / $scorePresence;

        //dd($scores); die;

        return $this->render('player/read.html.twig', [
            'player' => $player,
            'players' => $playerRepository->findAll(),
            'lootHistories' => $lootHistories,
            'nbPresences' => $nbPresences,
            'nbBenches' => $nbBenches,
            'nbItemBis' => $nbItemBis,
            'nbItemContested' => $nbItemContested,
            'scores' => $scores,
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

            // $this->addFlash('warning', 'Joueur modifié');
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

        // $this->addFlash('success', 'Joueur supprimé');
        return $this->redirectToRoute('app_player_list', [], Response::HTTP_SEE_OTHER);
    }
}
