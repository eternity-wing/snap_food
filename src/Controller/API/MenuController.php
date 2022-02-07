<?php

namespace App\Controller\API;

use App\Repository\FoodRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends BaseAPIController
{

    #[Route('/api/v1/menu', name: 'api_v1_menu_index')]
    public function index(FoodRepository $foodRepository): Response
    {
        return $this->json($this->serializer->serialize($foodRepository->findAvailableFoods(), 'json'));
    }
}
