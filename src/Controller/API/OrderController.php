<?php

namespace App\Controller\API;

use App\Exception\InvalidRequestException;
use App\Service\OrderProcessor\OrderProcessor;
use App\Service\Validator\OrderRequestValidator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends BaseAPIController
{
    #[Route('/api/v1/orders', name: 'api_v1_orders_new', methods: ["POST"])]
    public function create(Request $request, OrderRequestValidator $orderRequestValidator, OrderProcessor $orderProcessor): Response
    {
        try {
            $foodId = $request->request->getInt('foodId', 0);
            $userId = $request->request->getInt('userId', 0);
            $orderRequestValidator->validate($foodId, $userId);
            $order = $orderProcessor->process($foodId, $userId);
            return $this->json($this->serializer->serialize($order, 'json'));
        }catch (InvalidRequestException $exception){
            throw $this->proceedInvalidRequestException($exception);
        }
    }
}
