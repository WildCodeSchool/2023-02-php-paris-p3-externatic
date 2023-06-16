<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/offer', name: 'offer_')]
class OfferController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(OfferRepository $offerRepository): Response
    {
        $offers = $offerRepository->findAll();

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Offer $offer): Response
    {
        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }
}
