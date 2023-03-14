<?php

namespace App\Controller;

use App\Repository\PlayerRepository;
use App\Repository\StatsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StatsController extends AbstractController
{
    /**
     * @Route("/stats", name="app_stats")
     */
    public function index(PlayerRepository $playerRepository, StatsRepository $statsRepository, Request $request): Response
    {
        //TODO tableau qui compte par Role + Total : Nb Joueurs, Nb Loots NM, Nb Loots HM, Ratio loot/joueurs
        //TODO méthode qui sort le score moyen de la guilde
        //TODO méthode qui sort le score myen des DPS
        //TODO tableaux par rôle qui compte par joueus + Moyenne + Total : Role, Participation, Nb Loots NM, Nb Loots HM, Nb Loot Contested, Score 

        // datas for table
        $players = $playerRepository->findAll();
        $this-> playerRepository = $playerRepository;

        // sum by player
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
        
        // moy by role
        //somme des participations par joueur > COUNT(nbPresenceByPlayer) divisée par le nombre de joueurs
        $sumNbPresence = $statsRepository ->findSumNbPresence();
        
        // dd(($roles)); die;

        return $this->render('stats/index.html.twig', [
            'controller_name' => 'StatsController',
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
            'sumNbPresence' => $sumNbPresence,
        ]);

    }
}
