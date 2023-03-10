<?php

namespace App\Controller\Back;

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
 * @Route("/admin/player", name="app_admin_player_")
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
        // datas for table
        $players = $playerRepository->findAll();        
        
        $nbPresenceByPlayer = [];
        foreach ($players as $player) {
            $nbPresence = $this-> playerRepository->findNbPresenceByPlayer($player->getId());
            $nbPresenceByPlayer[$player->getId()] = $nbPresence;
        }
        
        $nbBenchByPlayer = [];
        foreach ($players as $player) {
            $nbBench = $this-> playerRepository->findnbBenchByPlayer($player->getId());
            $nbBenchByPlayer[$player->getId()] = $nbBench;
        }                
        
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
        
        $scores = [];
        foreach ($players as $player) {
            $scores[$player->getId()] = $player->getScore();
        }

        // datas for stats (right container)
        $participations = $playerRepository->findPlayerByParticipation();
        $benchs = $playerRepository->findPlayerByBench();
        $ranks = $playerRepository->findPlayerByRank();
        $roles = $playerRepository->findPlayerByRole();

        return $this->render('back/player/list.html.twig', [
            'controller_name' => 'PlayerController',
            'players' => $players,
            'roles' => $roles,
            'participations' => $participations,
            'nbPresenceByPlayer' => $nbPresenceByPlayer,
            'nbBenchByPlayer' => $nbBenchByPlayer,
            'nbItemNMByPlayer' => $nbItemNMByPlayer,
            'nbItemHMByPlayer' => $nbItemHMByPlayer,
            'nbItemContestedByPlayer' => $nbItemContestedByPlayer,
            'ranks' => $ranks,
            'benchs' => $benchs,
        ]);
    }


    /**
     * @Route("/update-scores", name="update_scores", methods={"POST"})
     */
    public function updateScores(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $players = $this->playerRepository->findAll();

        foreach ($players as $player) {
            $nbItemNM = $this->playerRepository->findNbItemNMByPlayer($player->getId())[0]['nbItemNM'];
            $nbItemHM = $this->playerRepository->findNbItemHMByPlayer($player->getId())[0]['nbItemHM'];
            $nbItemContested = $this->playerRepository->findNbItemContestedByPlayer($player->getId())[0]['nbItemContested'];
            $participations = $this->playerRepository->findNbPresenceByPlayer($player->getId())[0]['nbPresence'];
            $benches = $this->playerRepository->findNbBenchByPlayer($player->getId())[0]['nbBench'];

            $scoreItems = ($nbItemNM * 0.8) + ($nbItemHM * 1) + ($nbItemContested * 2);
            $scorePerPlayer = $participations + $benches > 0 ? $scoreItems / ($participations + $benches) : 0;
            
            $player->setScore(number_format($scorePerPlayer, 3));
            $entityManager->persist($player);
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_admin_player_list');
    }

    /**
     * @Route("/inactifs", name="list_inactifs", methods={"GET"})
     */
    public function listInactifs(PlayerRepository $playerRepository, Request $request): Response
    {
        // datas for table
        $players = $playerRepository->findAll();        
        
        $nbPresenceByPlayer = [];
        foreach ($players as $player) {
            $nbPresence = $this-> playerRepository->findNbPresenceByPlayer($player->getId());
            $nbPresenceByPlayer[$player->getId()] = $nbPresence;
        }
        
        $nbBenchByPlayer = [];
        foreach ($players as $player) {
            $nbBench = $this-> playerRepository->findnbBenchByPlayer($player->getId());
            $nbBenchByPlayer[$player->getId()] = $nbBench;
        }                
        
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
        
        $scores = [];
        foreach ($players as $player) {
            $scores[$player->getId()] = $player->getScore();
        }

        // datas for stats (right container)
        $participations = $playerRepository->findPlayerByParticipation();
        $benchs = $playerRepository->findPlayerByBench();
        $ranks = $playerRepository->findPlayerByRank();
        $roles = $playerRepository->findPlayerByRole();

        return $this->render('back/player/list_inactifs.html.twig', [
            'controller_name' => 'PlayerController',
            'players' => $players,
            'roles' => $roles,
            'participations' => $participations,
            'nbPresenceByPlayer' => $nbPresenceByPlayer,
            'nbBenchByPlayer' => $nbBenchByPlayer,
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
            return $this->redirectToRoute('app_admin_player_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/player/create.html.twig', [
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

        return $this->render('back/player/read.html.twig', [
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
            return $this->redirectToRoute('app_admin_player_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/player/update.html.twig', [
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
        return $this->redirectToRoute('app_admin_player_list', [], Response::HTTP_SEE_OTHER);
    }
}
