<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\RequestCompany;
use App\Entity\User;
use App\Form\CompanyCodeType;
use App\Form\CompanyType;
use App\Form\RequestCompanyType;
use App\Repository\CompanyRepository;
use App\Repository\RequestCompanyRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class RequestCompanyController extends AbstractController
{
    #[Security("(is_granted('ROLE_ADMIN'))")]
    #[Route('/admin/request', name: 'app_request_index', methods: ['GET'])]
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
            $requester = $this->getUser();
            $requestCompany->setRequestor($requester);
            $requestCompanyRepository->save($requestCompany, true);

            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/new.html.twig', [
            'requestCompany' => $requestCompany,
            'form' => $form,
        ]);
    }

    #[Route('/request/join', name: 'app_company_request_join', methods: ['GET', 'POST'])]
    public function join(Request $request, RequestCompanyRepository $requestCompanyRepository, CompanyRepository $companyRepository, UserRepository $userRepository): Response
    {
        $companyToAdd = new Company();
        $form = $this->createForm(CompanyCodeType::class, $companyToAdd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $requester */
            $requester = $this->getUser();

            $code = $companyToAdd->getCode();

            $companies = $companyRepository->findAll();

            // Boucle sur la liste des companies pour vérifier si le code correspond
            foreach ($companies as $company) {
                if (password_verify($code, $company->getCode())) {
                    // le code a été trouvé dans la table "Company"
                    //$this->addFlash('success', 'Code valide');
                    $requester->setIsOwner(false);
                    $requester->setCompany($company);
                    $requester->setRoles(["ROLE_COMPANY"]);
                    $userRepository->save($requester, true);

                    return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
                }
            }

            return $this->redirectToRoute('app_company_request_join', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/join.html.twig', [
            'company' => $companyToAdd,
            'form' => $form,
        ]);

    }
}