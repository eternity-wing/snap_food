<?php

namespace App\Controller\API;

use App\Repository\FoodRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends BaseAPIController
{

    //TODO: findAvailableFoods is not implemented yet and returns all foods
    #[Route('/api/v1/menu', name: 'api_v1_menu_index')]
    public function index(FoodRepository $foodRepository): Response
    {
        $response = new Response($this->serializer->serialize($foodRepository->findAvailableFoods(), 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
