<?php

namespace App\Controller;

use App\Entity\Company;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}