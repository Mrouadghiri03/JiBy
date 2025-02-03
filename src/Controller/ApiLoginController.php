<?php

namespace App\Controller;

// use App\Controller\Response;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\Routing\Attribute\Route;
// use App\Entity\User;
// use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

// final class ApiLoginController extends AbstractController
// {
//     #[Route('/api/login', name: 'app_api_login')]
//     public function index(): JsonResponse
//     {
//         return $this->json([
//             'message' => 'Welcome to your new controller!',
//             'path' => 'src/Controller/ApiLoginController.php',
//         ]);
//     }
// }

class ApiLoginController extends AbstractController
{

     #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user): JsonResponse
    {
         if (null === $user) {
             return $this->json([
                 'message' => 'missing credentials',
             ], JsonResponse::HTTP_UNAUTHORIZED);
         }

      //   $token = ...; // somehow create an API token for $user

        return $this->json([
    
             'user'  => $user->getUserIdentifier(),
             
        ]);
    }
}