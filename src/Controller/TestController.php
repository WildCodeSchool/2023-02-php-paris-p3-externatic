<?php

namespace App\Controller;

use App\Form\SearchOfferFilterType;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/', name:'index')]
    public function index(Request $request, OfferRepository $offerRepository)
    {
        $form = $this->createForm(SearchOfferFilterType::class);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {
            var_dump($form->getData());
            $filters = $form->getData();
            $offers = $offerRepository->findwithFilter($filters);
        } else {
            $offers = $offerRepository->findAll();
        }
        
        return $this->render('test/index.html.twig', [
            'form' => $form,
            'offers' => $offers,
        ]);
    }
}