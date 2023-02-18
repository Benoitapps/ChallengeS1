<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\RequestCompany;
use App\Form\CompanyType;
use App\Form\RequestCompanyType;
use App\Repository\CompanyRepository;
use App\Repository\RequestCompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class RequestCompanyController extends AbstractController
{
    #[Route('/request', name: 'app_request_index', methods: ['GET'])]
    public function index(RequestCompanyRepository $requestCompanyRepository): Response
    {



        /*  return $this->render('request_company/index.html.twig', [
            'controller_name' => 'RequestCompanyController',

        ]);*/

        return $this->render('request_company/index.html.twig', [
            'requestCompanies' => $requestCompanyRepository->findAll(),
        ]);
    }



    /* #[Route('/request/new', name: 'app_company_request_new', methods: ['POST'])]
    public function new(Request $request, RequestCompanyRepository $requestCompanyRepository): Response
    {
        $requestCompany = new RequestCompany();
        $form = $this->createForm(CompanyType::class, $requestCompany);
        $form->handleRequest($request);

        $requestCompany->setStatus("NOT_ACCEPTED");

        if ($form->isSubmitted() && $form->isValid()) {
            $requestCompanyRepository->save($requestCompany, true);

            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/new.html.twig', [
            'company' => $requestCompany,
            'form' => $form,
        ]);
    }
*/

    #[Route('/request/new', name: 'app_company_request_new', methods: ['GET','POST'])]
    public function new(Request $request, RequestCompanyRepository $requestCompanyRepository): Response
    {


        $requestCompany = new RequestCompany();
        $form = $this->createForm(RequestCompanyType::class, $requestCompany);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $requestor = $this->getUser();
            $requestCompany->setRequestor($requestor);
            $requestCompanyRepository->save($requestCompany, true);

            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/new.html.twig', [
            'requestCompany' => $requestCompany,
            'form' => $form,
        ]);
    }
    function generateCode($longueur = 8)
    {
        $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longueurMax = strlen($caracteres);
        $chaineAleatoire = '';
        for ($i = 0; $i < $longueur; $i++)
        {
            $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
        }
        return $chaineAleatoire;
    }
}
