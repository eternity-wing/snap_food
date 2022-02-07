<?php

namespace App\Controller\API;

use App\Exception\InvalidRequestException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class BaseAPIController extends AbstractController
{
    public function __construct(protected SerializerInterface $serializer)
    {
    }


    public function proceedInvalidRequestException(InvalidRequestException $exception): \Symfony\Component\HttpFoundation\JsonResponse
    {
        if ($exception->getCode() === 404) {
            return $this->json([], status: 404);
        }

        return $this->json(['type' => 'Bad Request', 'title' => $exception->getMessage(), 'errors' => $exception->getErrors()], status: 400);

    }
}
