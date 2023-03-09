<?php

namespace App\Controller\Front;

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

        return $this->render('front/player/list.html.twig', [
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

        return $this->render('front/player/list_inactifs.html.twig', [
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

        return $this->render('front/player/read.html.twig', [
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
}
