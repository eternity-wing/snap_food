<?php

namespace App\Controller\API;

use App\Repository\FoodRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class MenuController extends AbstractController
{

    #[Route('/api/v1/menu', name: 'api_v1_menu_index')]
    public function index(FoodRepository $foodRepository, SerializerInterface $serializer): Response
    {
        return $this->json($serializer->serialize($foodRepository->findAvailableFoods(), 'json'));
    }
}
