<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Candidate;
use App\Entity\Company;
use App\Form\ApplicationStatusType;
use App\Form\CompanyType;
use App\Repository\ApplicationRepository;
use App\Repository\CompanyRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company', name: 'company_')]
#[IsGranted('ROLE_COMPANY')]
class CompanyController extends AbstractController
{
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompanyRepository $companyRepository): Response
    {
        $company = $this->getUser()->getCompany();

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->save($company, true);

            $this->addFlash('success', 'Your account has been created! :)');

            return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company/new.html.twig', [
            'company' => $company,
            'form' => $form
        ]);
    }

    #[Route('/{id}/offers', name: 'offers')]
    public function indexOffers(Company $company): Response
    {
        return $this->render('company/indexOffer.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Company $company, Request $request, CompanyRepository $companyRepository): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->save($company, true);

            $this->addFlash('success', 'Your account has been updated! :)');

            return $this->redirectToRoute('company_offers', ['id' => $company->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/candidate/application/{id}', name: 'candidate_application')]
    public function candidateApplication(
        Application $application,
        Request $request,
        ApplicationRepository $repository,
        Company $company,
    ): Response {
        $form = $this->createForm(ApplicationStatusType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $repository->save($application, true);

            return $this->redirectToRoute('company_offers', [
                'id' => $application->getOffer()->getCompany()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company/candidateApplication.html.twig', [
            'application' => $application,
            'company' => $company,
            'form' => $form,
        ]);
    }
}
