<?php

namespace App\Controller\Front;

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
        return $this->render('front/item/list.html.twig', [
            'controller_name' => 'ItemController',
            'items' => $itemRepository->findAll(),
        ]);
    }
}
