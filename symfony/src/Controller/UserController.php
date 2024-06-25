<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/api/user', name: 'api_user', methods: ['GET'])]
    public function getCurrentUser(Security $security,  SerializerInterface $serializer): JsonResponse
    {
        $user = $security->getUser();

        if (!$user) {
            return new JsonResponse(['error' => 'User not authenticated'], JsonResponse::HTTP_UNAUTHORIZED);
        }
        
        $data = $serializer->serialize($user, 'json', ['groups' => 'user:read']);
        
        return JsonResponse::fromJsonString($data);
    }
}