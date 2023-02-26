<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(): Response
    {
        //$user = $this->getUser();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            //'user' => $user
        ]);
    }

    #[Security("(is_granted('ROLE_CUSTOMER'))")]
    #[Route('/contact', name: 'app_default_contact')]
    public function contact(): Response
    {
        return $this->render('default/contact.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/admin', name: 'app_admin')]
    public function admin(): Response
    {
        return $this->render('admin/admin.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}
