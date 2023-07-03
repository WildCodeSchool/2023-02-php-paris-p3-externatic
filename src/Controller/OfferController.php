<?php

namespace App\Controller;

use App\Form\SearchOfferFilterType;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends AbstractController
{
    #[Route('/', name:'index', methods: ['GET', 'POST'])]
    public function index(Request $request, OfferRepository $offerRepository): Response
    {
        $form = $this->createForm(SearchOfferFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            $offers = $offerRepository->findwithFilter($filters);
        } else {
            $offers = $offerRepository->findAll();
        }

        return $this->render('offer/index.html.twig', [
            'form' => $form,
            'offers' => $offers,
        ]);
    }
}
