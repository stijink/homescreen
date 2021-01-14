<?php

namespace App\Controller;

use App\Component\BringShoppingList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingListController extends AbstractController
{
    public function __construct(private BringShoppingList $shoppingListComponent)
    {
    }

    /**
     * @Route("/shopping-list", name="shopping_list", format="json")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->shoppingListComponent->load());
    }
}
