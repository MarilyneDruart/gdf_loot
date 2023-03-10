<?php

namespace App\Controller\Front;

use App\Repository\ItemRepository;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="app_search")
     */
    public function index(): Response
    {
        return $this->render('front/search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function itemSearchBar(): Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handleItemSearch'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'search-bar',
                    'placeholder' => 'Saisissez le nom de l\'item'
                ]
            ])
            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'button-search'
                ]
            ])
            ->getForm();
        return $this->render('front/search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function playerSearchBar(): Response
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('handlePlayerSearch'))
            ->add('query', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'search-bar',
                    'placeholder' => 'Saisissez le nom du joueur'
                ]
            ])
            ->add('recherche', SubmitType::class, [
                'attr' => [
                    'class' => 'button-search'
                ]
            ])
            ->getForm();
        return $this->render('front/search/searchBar.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/handleItemSearch", name="handleItemSearch")
     * @param Request $request
     */
    public function handleItemSearch(Request $request, ItemRepository $itemRepository)
    {
        $query = $request->request->all('form')['query'];
        if($query) {
            $items = $itemRepository->findItemsByName($query);
        }
        return $this->render('front/search/item_index.html.twig', [
            'items' => $items,
        ]);
    }

    /**
     * @Route("/handlePlayerSearch", name="handlePlayerSearch")
     * @param Request $request
     */
    public function handlePlayerSearch(Request $request, PlayerRepository $playerRepository)
    {
        $query = $request->request->all('form')['query'];
        if($query) {

            $players = $playerRepository->findPlayersByName($query);
        }
        return $this->render('front/search/player_index.html.twig', [
            'players' => $players,
        ]);
    }
}
