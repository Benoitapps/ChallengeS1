<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\RequestCompany;
use App\Entity\User;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use App\Repository\RequestCompanyRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


#[Route('/company')]
class CompanyController extends AbstractController
{
    #[Route('/', name: 'app_company_index', methods: ['GET'])]
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('company/index.html.twig', [
            'companies' => $companyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompanyRepository $companyRepository): Response
    {


        $company = new Company();
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->save($company, true);

            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/new.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }


    /**
     * @throws \Exception
     */
    #[Route('/add/{id}', name: 'app_company_add', methods: ['GET', 'POST'])]
    public function add(Request $request,int $id, RequestCompanyRepository $requestCompanyRepository, CompanyRepository $companyRepository, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {





        $requestCompany = $requestCompanyRepository->find($id);

        $company = new Company();
        $company->setName($requestCompany->getName());
        $company->setSiren($requestCompany->getSiren());
        $company->setCode(password_hash($this->generateRandomToken(), PASSWORD_DEFAULT));
        $companyRepository->save($company, true);
        $requestor = $requestCompany->getRequestor();
        $requestor->setCompany($company);
        $requestor->setIsOwner(1);
        $userRepository->save($requestor, true);
        $requestCompanyRepository->remove($requestCompany, true);
        return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);

    }

    /**
     * @throws \Exception
     */
    private function generateRandomToken() {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < 8; $i++) {
            $token .= $characters[random_int(0, strlen($characters) - 1)];
        }
        return $token;
    }



    #[Route('/joinId/{id}', name: 'app_company_join_by_id', methods: ['POST'])]
    public function joinById(Request $request,  Company $company, UserRepository $userRepository): Response
    {
        $user = $this->getUser();

        if ($this->isCsrfTokenValid('joinById'.$company->getId(), $request->request->get('_token'))) {
            if($user->getCompany() == null) {
                $user->setCompany($company);
                $userRepository->save($user, true);
            } else {
                return $this->redirectToRoute('app_company_join', [], Response::HTTP_SEE_OTHER);
            }
        }
        return $this->redirectToRoute('app_company_join', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/join/{code}', name: 'app_company_join', methods: ['GET'])]
    public function join(CompanyRepository $companyRepository, UserRepository $userRepository): Response
    {

        $companies = $companyRepository->findAll();
        $user = $this->getUser();


        return $this->render('company/joinCompany.html.twig', [
            'companies' => $companies,
            'userCompany' => $user->getCompany(),
        ]);

    }





    #[Route('/{id}', name: 'app_company_show', methods: ['GET'])]
    public function show(Company $company): Response
    {
        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_company_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Company $company, CompanyRepository $companyRepository): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->save($company, true);

            return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_company_delete', methods: ['POST'])]
    public function delete(Request $request, Company $company, CompanyRepository $companyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $companyRepository->remove($company, true);
        }

        return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
    }
}
