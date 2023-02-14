<?php

namespace App\Controller;

use App\Entity\Annonce;

use App\Entity\Payment;
use App\Entity\Place;
use App\Form\AnnonceType;
use App\Form\PaymentType;
use App\Form\PlaceType;
use App\Repository\AnnonceRepository;
use App\Repository\PaymentRepository;
use App\Repository\PlaceRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;



#[Route('/annonce')]
class AnnonceController extends AbstractController
{

    #[Route('/', name: 'app_annonce_index', methods: ['GET'])]
    public function index(AnnonceRepository $annonceRepository): Response
    {

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonceRepository->findAll(),
        ]);
    }
    #[Security("is_granted('ROLE_COMPANY')")]
    #[Route('/new', name: 'app_annonce_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_COMPANY')]
    public function new(Request $request, AnnonceRepository $annonceRepository, PaymentRepository $paymentRepository): Response
    {
        $annonce = new Annonce();
        $annonce->setClient($this->getUser());
        $dateAujourdhui = new DateTime();
        $dateAujourdhui->modify('+4 days');

        $annonce->setDateAnnonce($dateAujourdhui);
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);


        if (($form->isSubmitted() && $form->isValid()) ) {
            $annonceRepository->save($annonce, true);

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonce/new.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }

    //redirection perso

    #[Route('/perso', name: 'app_annonce_perso', methods: ['GET', 'POST'])]
    public function perso(Request $request, AnnonceRepository $annonceRepository): Response
    {
        $place = new Place();
        return $this->render('annonce/perso.html.twig', [
            'annonces' => $annonceRepository->findAll(),
            'place' => $place
        ]);
    }

    //redirection panier
    #[Route('/panier', name: 'app_annonce_panier', methods: ['GET', 'POST'])]
    public function panier(Request $request, AnnonceRepository $annonceRepository, PaymentRepository $paymentRepository): Response
      {
          $place = new Place();
          $payment = new Payment();
          $utilisateur = $this->getUser();
          $payment->setPayeur($utilisateur);
          $formPay = $this->createForm(PaymentType::class,$payment);
          $formPay->handleRequest($request);

          if ($formPay->isSubmitted() && $formPay->isValid())  {
              $paymentRepository->save($payment, true);

              return $this->redirectToRoute('app_annonce_panier', [], Response::HTTP_SEE_OTHER);
          }

          return $this->render('annonce/panier.html.twig', [
              'annonces' => $annonceRepository->findAll(),
              'formPay' => $formPay->createView(),
              'place' => $place,
          ]);
      }

    //redirection payer
    #[Route('/pay/{id}', name: 'app_annonce_pay', methods: ['GET', 'POST'])]
    public function pay(Request $request, AnnonceRepository $annonceRepository, Annonce $annonce, PaymentRepository $paymentRepository, PlaceRepository $placeRepository): Response
        {
            $utilisateur = $this->getUser();

            $payment = new Payment();
            $payment->setPayeur($utilisateur);
            $formPay = $this->createForm(PaymentType::class,$payment);
            $formPay->handleRequest($request);

            $idplace = $request->query->get('idplace');
            $place = $placeRepository->find($idplace);


            $place->setAcheteur($utilisateur);
            $place->setReservation($annonce);
            $place->setPayer(true);
            $formPlace = $this->createForm(PlaceType::class,$place,array(
                'variable' => $annonce->getPlace()
            ));
            $formPlace->handleRequest($request);

            if ($formPay->isSubmitted() && $formPay->isValid() && $formPlace->isSubmitted() && $formPlace->isValid()) {
                $annonce->setCreator($this->getUser());

                $placeacheter = $place->getNb();
                $placetotal = $annonce->getPlace();
                $placeres = $placetotal - $placeacheter;

                $annonce->setPlace($placeres);

                $annonceRepository->save($annonce, true);
                $placeRepository->save($place, true);
                $placeRepository->save($place, true);

                return $this->redirectToRoute('app_annonce_panier', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('annonce/pay.html.twig', [
                'annonces' => $annonceRepository->findAll(),
                'annonce' => $annonce,
                'formPay' => $formPay->createView(),
                'formPlace'=> $formPlace->createView(),
            ]);
        }



    //ajouter au panier
    #[Route('/ajouter/{id}', name: 'app_annonce_ajouter', methods: ['GET', 'POST'])]
    public function ajouter(Request $request, AnnonceRepository $annonceRepository, Annonce $annonce, PlaceRepository $placeRepository): Response
    {
        $place = new Place();
        $utilisateur = $this->getUser();
        $place->setAcheteur($utilisateur);
        $place->setReservation($annonce);
        $place->setPayer(false);
        $place->setNb(null);
        $annonce->addBuyer($utilisateur);
        $annonceRepository->save($annonce,true);
        $placeRepository->save($place,true);

        return $this->redirectToRoute('app_annonce_panier');
    }

    //Paiement
    #[Route('/paiment/{id}', name: 'app_annonce_paiment', methods: ['GET', 'POST'])]
    public function paiment(Request $request, AnnonceRepository $annonceRepository, Annonce $annonce): Response
    {

        $place = new Place();
        $place->setPayer(true);

        $annonceRepository->save($annonce,true);

        return $this->redirectToRoute('app_annonce_panier');
    }



    //enlever de panier

    #[Route('/annuler/{id}', name: 'app_annonce_annuler', methods: ['GET', 'POST'])]
    public function annuler(Request $request, AnnonceRepository $annonceRepository, Annonce $annonce): Response
    {
        $utilisateur = $this->getUser();
        $annonce->removeBuyer($utilisateur);
        $annonceRepository->save($annonce,true);

        return $this->redirectToRoute('app_annonce_panier');
    }


    //afficher

    #[Route('/{id}', name: 'app_annonce_show', methods: ['GET'])]
    public function show(Annonce $annonce): Response
    {
        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }



    //Modifier

    #[Security("(is_granted('ROLE_COMPANY') and user === annonce.getClient()) or is_granted('ROLE_ADMIN')")]
    #[Route('/{id}/edit', name: 'app_annonce_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        $form = $this->createForm(AnnonceType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonceRepository->save($annonce, true);

            return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('annonce/edit.html.twig', [
            'annonce' => $annonce,
            'form' => $form->createView(),
        ]);
    }


    //Supprimer

    #[Security("is_granted('ROLE_COMPANY') and user === annonce.getClient()")]
    #[Route('/{id}', name: 'app_annonce_delete', methods: ['POST'])]
    public function delete(Request $request, Annonce $annonce, AnnonceRepository $annonceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$annonce->getId(), $request->request->get('_token'))) {
            $annonceRepository->remove($annonce, true);
        }

        return $this->redirectToRoute('app_annonce_index', [], Response::HTTP_SEE_OTHER);
    }
}
