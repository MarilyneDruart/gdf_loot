<?php

namespace App\Controller;

use App\Entity\Raid;
use App\Form\RaidType;
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
        return $this->render('raid/list.html.twig', [
            'controller_name' => 'RaidController',
            'raids' => $raidRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, RaidRepository $raidRepository): Response
    {
        $raid = new Raid();

        $form = $this->createForm(RaidType::class, $raid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $raidRepository->add($raid, true);

            // $this->addFlash('success', 'Raid ajouté');
            return $this->redirectToRoute('app_raid_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('raid/create.html.twig', [
            'raid' => $raid,
            'form' => $form,
        ]);
    }

    /**
     * @Route ("/{id<\d+>}", name="read", methods={"GET"})
     * @Route ("/{slug}", name="show_by_slug", methods={"GET"})
     */
    public function read(Raid $raid): Response
    {
        return $this->render('raid/read.html.twig', [
            'raid' => $raid,
        ]);
    }

    /**
     * @Route ("/{id<\d+>}/update", name="update", methods={"GET", "POST"})
     */
    public function update(Request $request, Raid $raid, RaidRepository $raidRepository): Response
    {
        $form = $this->createForm(RaidType::class, $raid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $raidRepository->add($raid, true);

            // $this->addFlash('warning', 'Raid modifié');
            return $this->redirectToRoute('app_raid_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('raid/update.html.twig', [
            'raid' => $raid,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Raid $raid, RaidRepository $raidRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raid->getId(), $request->request->get('_token'))) {
            $raidRepository->remove($raid, true);
        }

        // $this->addFlash('success', 'Raid supprimé');
        return $this->redirectToRoute('app_raid_list', [], Response::HTTP_SEE_OTHER);
    }
}
