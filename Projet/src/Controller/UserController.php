<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\AnnonceRepository;
use App\Repository\PlaceRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security("is_granted('ROLE_ADMIN')")]
#[Route('/user')]
class UserController extends AbstractController
{
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findBy([], ['email' => 'ASC']),
        ]);
    }

    /*#[Route('/valide/{id}', name: 'app_user_index', methods: ['GET'])]
    public function valide(User $user ,UserRepository $userRepository): Response
    {
        $user->getCompany()->setCompanyVerified(true);
        $userRepository->save($user);
        return $this->redirectToRoute('app_user_index');

    }*/

    /*#[Route('/join/{id}', name: 'app_user_join', methods: ['GET'])]
    public function join(User $user ,UserRepository $userRepository): Response
    {
        $user->setCompany(Company::)
;        $userRepository->save($user);
        return $this->redirectToRoute('app_user_index');

    }*/
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/admin/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Convertir la chaîne de caractères en tableau
            $roles = explode(',', $form->get('roles')->getData());
            $user->setRoles($roles);

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/admin/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/admin/annonce/{id}', name: 'app_user_annonce', methods: ['GET'])]
    public function anonce(User $user, PlaceRepository $placeRepository,int $id): Response
    {
        $places = $placeRepository->findBy(['acheteur' => $id]);


        return $this->render('user/show.html.twig', [
            'places' => $places,
            'user' => $user,
        ]);
    }


    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/admin/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $roles = explode(',', $form->get('roles')->getData());
            $user->setRoles($roles);

            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    #[Security("is_granted('ROLE_ADMIN')")]
    #[Route('/admin/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
