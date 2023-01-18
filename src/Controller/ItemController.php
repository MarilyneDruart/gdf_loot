<?php

namespace App\Controller;

use App\Entity\Item;
use App\Form\ItemType;
use App\Utils\MySlugger;
use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/item", name="app_item_")
 */
class ItemController extends AbstractController
{
    
    /**
     * @Route("/", name="list", methods={"GET"})
     */
    public function list(ItemRepository $itemRepository): Response
    {
        return $this->render('item/list.html.twig', [
            'controller_name' => 'ItemController',
            'items' => $itemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="create", methods={"GET", "POST"})
     */
    public function create(Request $request, ItemRepository $itemRepository, MySlugger $mySlugger): Response
    {
        $item = new Item();

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $item->setSlug($mySlugger->slugify($item->getName()));
            $itemRepository->add($item, true);

            $this->addFlash('success', 'Item ajouté');
            return $this->redirectToRoute('app_item_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/create.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    /**
     * @Route ("/{id<\d+>}", name="read", methods={"GET"}, requirements={"id"="\d+"})
     * @Route ("/{slug}", name="show_by_slug", methods={"GET"})
     */
    public function read(Item $item): Response
    {
        return $this->render('item/read.html.twig', [
            'item' => $item,
        ]);
    }

    /**
     * @Route ("/{id<\d+>}/update", name="update", methods={"GET", "POST"})
     */
    public function update(Request $request, Item $item, ItemRepository $itemRepository): Response
    {
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $itemRepository->add($item, true);

            $this->addFlash('warning', 'Item modifié');
            return $this->redirectToRoute('app_item_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('item/update.html.twig', [
            'item' => $item,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="delete", methods={"POST"})
     */
    public function delete(Request $request, Item $item, ItemRepository $itemRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->request->get('_token'))) {
            $itemRepository->remove($item, true);
        }

        $this->addFlash('success', 'Item supprimé');
        return $this->redirectToRoute('app_item_list', [], Response::HTTP_SEE_OTHER);
    }
}
