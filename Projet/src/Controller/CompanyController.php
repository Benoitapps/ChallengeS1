<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\User;
use App\Entity\RequestCompany;
use App\Form\CompanyType;
use App\Service\EmailService;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use App\Repository\RequestCompanyRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Integer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/company')]
class CompanyController extends AbstractController
{
    #[Security("(is_granted('ROLE_COMPANY'))")]
    #[Route('/', name: 'app_company_index', methods: ['GET'])]
    public function index(CompanyRepository $companyRepository): Response
    {
        return $this->render('company/index.html.twig', [
            'companies' => $companyRepository->findAll(),
        ]);
    }

    #[Security("(is_granted('ROLE_ADMIN'))")]
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
    #[Security("(is_granted('ROLE_ADMIN'))")]
    #[Route('/add/{id}', name: 'app_company_add', methods: ['GET', 'POST'])]
    public function add(Request $request,int $id, RequestCompanyRepository $requestCompanyRepository, CompanyRepository $companyRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, EmailService $emailService): Response
    {

        $requestCompany = $requestCompanyRepository->find($id);

        $company = new Company();
        $company->setName($requestCompany->getName());
        $company->setSiren($requestCompany->getSiren());
        $randomToken = $this->generateRandomToken();
        $company->setCode(password_hash($randomToken, PASSWORD_DEFAULT));
        $companyRepository->save($company, true);
        $requestor = $requestCompany->getRequestor();
        $requestor->setCompany($company);
        $requestor->setIsOwner(1);
        $requestor->setRoles(["ROLE_COMPANY"]);
        $userRepository->save($requestor, true);
        $requestCompanyRepository->remove($requestCompany, true);

        $userEmail = $requestor->getEmail();
        $templateId = 5; //TemplateId = 5 pour acceptation partenaire avec code
        $params = array('name'=>'BECLAL', 'USER'=>$userEmail,'COMPANY'=>$company->getName(), 'CODE'=>$randomToken);
        try {
            $emailService->sendTransactionalEmail($userEmail, $templateId, $params);
        } catch (Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'e-mail : ' . $e->getMessage());
        }

        return $this->redirectToRoute('app_request_index', [], Response::HTTP_SEE_OTHER);


    }

    #[Security("(is_granted('ROLE_COMPANY'))")]
    #[Route('/resend/invite', name: 'app_company_resend_invite', methods: ['GET', 'POST'])]
    public function sendInvite(Request $request, RequestCompanyRepository $requestCompanyRepository, CompanyRepository $companyRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, EmailService $emailService): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $company = $user->getCompany();

        $randomToken = $this->generateRandomToken();
        $company->setCode(password_hash($randomToken, PASSWORD_DEFAULT));
        $companyRepository->save($company, true);

        $userEmail = $user->getEmail();
        $templateId = 6; //TemplateId = 6 pour g??n??rer un nouveau code
        $params = array('name'=>'BECLAL', 'USER'=>$userEmail, 'CODE'=>$randomToken);
        try {
            $emailService->sendTransactionalEmail($userEmail, $templateId, $params);
            $this->addFlash('success', 'Nouveau code d\'invitation envoy??');
        } catch (Exception $e) {
            $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de l\'e-mail : ' . $e->getMessage());
        }

        return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);


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

    #[Security("(is_granted('ROLE_ADMIN'))")]
    #[Route('/{id}', name: 'app_company_show', methods: ['GET'])]
    public function show(Company $company): Response
    {
        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }

    #[Security("(is_granted('ROLE_ADMIN'))")]
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

    #[Security("(is_granted('ROLE_ADMIN'))")]
    #[Route('/{id}', name: 'app_company_delete', methods: ['POST'])]
    public function delete(Request $request, Company $company, CompanyRepository $companyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$company->getId(), $request->request->get('_token'))) {
            $companyRepository->remove($company, true);
        }

        return $this->redirectToRoute('app_company_index', [], Response::HTTP_SEE_OTHER);
    }
}
