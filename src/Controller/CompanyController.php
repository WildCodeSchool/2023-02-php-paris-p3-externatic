<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Candidate;
use App\Entity\Company;
use App\Form\ApplicationStatusType;
use App\Repository\ApplicationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company', name:'company_')]
#[IsGranted('ROLE_COMPANY')]
class CompanyController extends AbstractController
{
    #[Route('/{id}/offers', name: 'offers')]
    public function indexOffers(Company $company): Response
    {
        return $this->render('company/indexOffer.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/candidate/application/{id}', name: 'candidate_application')]
    public function candidateApplication(
        Application $application,
        Request $request,
        ApplicationRepository $repository
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
            'form' => $form,
        ]);
    }
}
