<?php

namespace App\Controller;

use App\DTO\UserDTO;
use App\Mapper\UserMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function register(Request $request, SerializerInterface $serializer, EntityManagerInterface $entityManager, ValidatorInterface $validator, UserMapper $userMapper): JsonResponse
    {
        $userDTO = $serializer->deserialize($request->getContent(), UserDTO::class, 'json', ['groups' => 'user:write']);
        $user = $userMapper->dtoToEntity($userDTO);
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            $errorsArray = [];
            foreach ($errors as $error) {
                $errorsArray[] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $errorsArray], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'User created'], JsonResponse::HTTP_CREATED);
    }
}