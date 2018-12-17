<?php

namespace App\Controller;

use App\Component\BringShoppingList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingListController extends AbstractController
{
    private $shoppingListComponent;

    /**
     * @param BringShoppingList $shoppingListComponent
     */
    public function __construct(BringShoppingList $shoppingListComponent)
    {
        $this->shoppingListComponent = $shoppingListComponent;
    }

    /**
     * @Route("/shopping-list", name="shopping_list")
     *
     * @throws \App\ApiException
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->shoppingListComponent->load());
    }
}
