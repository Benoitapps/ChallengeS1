<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SendinBlue;
use GuzzleHttp;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function index(UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'user' => $user
        ]);
    }


    #[Route('/contact', name: 'app_default_contact')]
    public function contact(): Response
    {


        return $this->render('default/contact.html.twig', [
            'controller_name' => 'DefaultController',

        ]);
    }

}
