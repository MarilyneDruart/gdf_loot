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

    private $lootHistoryRepository;

    public function __construct(LootHistoryRepository $lootHistoryRepository, PlayerRepository $playerRepository)
    {
        $this->lootHistoryRepository = $lootHistoryRepository;
        $this->playerRepository = $playerRepository;
    }

    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(PlayerRepository $playerRepository, Request $request): Response
    {

        // sort by table column
        $sortBy = $request->query->get('sort', 'name'); // par défaut, tri par nom
        $sortOrder = $request->query->get('order', 'asc');

        // datas for the table (left container)
        $players = $playerRepository->findBy([], [$sortBy => $sortOrder]);
        $roles = $playerRepository->findPlayerByRole();
        $participations = $playerRepository->findPlayerByParticipation();
        $nbItemNMByPlayer = [];
        foreach ($players as $player) {
            $nbItemNM = $this->playerRepository->findNbItemNMByPlayer($player->getId());
            $nbItemNMByPlayer[$player->getId()] = $nbItemNM;
        }
        $nbItemHMByPlayer = [];
        foreach ($players as $player) {
            $nbItemHM = $this->playerRepository->findNbItemHMByPlayer($player->getId());
            $nbItemHMByPlayer[$player->getId()] = $nbItemHM;
        }
        $nbItemContestedByPlayer = [];
        foreach ($players as $player) {
            $nbItemContested = $this->playerRepository->findNbItemContestedByPlayer($player->getId());
            $nbItemContestedByPlayer[$player->getId()] = $nbItemContested;
        }
        
        // datas for the stats (right container)
        $ranks = $playerRepository->findPlayerByRank();
        $benchs = $playerRepository->findPlayerByBench();
        
        // dd($nbItemNMByPlayer); die;

        return $this->render('player/list.html.twig', [
            'controller_name' => 'PlayerController',
            'players' => $players,
            'roles' => $roles,
            'participations' => $participations,
            'nbItemNMByPlayer' => $nbItemNMByPlayer,
            'nbItemHMByPlayer' => $nbItemHMByPlayer,
            'nbItemContestedByPlayer' => $nbItemContestedByPlayer,
            'ranks' => $ranks,
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

        $lootHistories = $lootHistoryRepository->findLootHistoryBySlug($slug);
        $nbPresences = $lootHistoryRepository->findNbPresenceBySlug($slug);
        $nbBenches = $lootHistoryRepository->findNbBenchBySlug($slug);
        $nbItemNM = $lootHistoryRepository->findNbItemNMBySlug($slug);
        $nbItemHM = $lootHistoryRepository->findNbItemHMBySlug($slug);
        $nbItemContested = $lootHistoryRepository->findNbItemContestedBySlug($slug);
        $scores = $lootHistoryRepository->calculScoreBySlug($lootHistoryRepository, $slug);
        $setScore = $lootHistoryRepository->setCalculScoreBySlug($slug, $scores);
        //dd($setScore); die;       

        return $this->render('player/read.html.twig', [
            'player' => $player,
            'players' => $playerRepository->findAll(),
            'lootHistories' => $lootHistories,
            'nbPresences' => $nbPresences,
            'nbBenches' => $nbBenches,
            'nbItemNM' => $nbItemNM,
            'nbItemHM' => $nbItemHM,
            'nbItemContested' => $nbItemContested,
            'scores' => $scores,
            'setScore' => $setScore,
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
