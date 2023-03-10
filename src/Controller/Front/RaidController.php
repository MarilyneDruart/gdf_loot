<?php

namespace App\Controller\Front;

use App\Entity\Raid;
use App\Form\RaidType;
use App\Utils\MySlugger;
use App\Repository\RaidRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/raid", name="app_raid_")
 */
class RaidController extends AbstractController
{
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(RaidRepository $raidRepository): Response
    {
        return $this->render('front/raid/list.html.twig', [
            'controller_name' => 'RaidController',
            'raids' => $raidRepository->findAll(),
        ]);
    }

    /**
     * @Route ("/{id<\d+>}", name="read", methods={"GET"})
     * @Route ("/{slug}", name="show_by_slug", methods={"GET"})
     */
    public function read(Raid $raid): Response
    {
        return $this->render('front/raid/read.html.twig', [
            'raid' => $raid,
        ]);
    }
}
