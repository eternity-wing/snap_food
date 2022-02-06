<?php

namespace App\Controller\API;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{
    #[Route('/api/v1/orders', name: 'api_v1_orders_new', methods: ["POST"])]
    public function create(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/API/OrderController.php',
        ]);
    }
}
