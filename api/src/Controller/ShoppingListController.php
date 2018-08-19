<?php

namespace App\Controller;

use App\Component\BringShoppingList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ShoppingListController extends Controller
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
