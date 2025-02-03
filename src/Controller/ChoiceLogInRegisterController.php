<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ChoiceLogInRegisterController extends AbstractController
{
    #[Route('', name: 'app_choice_log_in_register')]
    public function index(): Response
    {
        return $this->render('choice_log_in_register/index.html.twig', [
            'controller_name' => 'ChoiceLogInRegisterController',
        ]);
    }
}
