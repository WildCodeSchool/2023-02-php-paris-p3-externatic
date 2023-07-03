<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\Application;
use App\Entity\Skill;
use App\Repository\ApplicationRepository;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;

#[Route('/offer', name: 'offer_')]
class OfferController extends AbstractController
{
    #[Route('/index', name: 'index', methods: ['GET', 'POST'])]
    public function index(OfferRepository $offerRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $offers = $paginator->paginate($offerRepository->findAll(), $request->query->getInt('page', 1), 6);

        $now = new DateTime();

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
            'now' => $now,
        ]);
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET', 'POST'])]
    public function show(Offer $offer): Response
    {
        $interval = date_diff(new DateTime(), $offer->getCreatedAt());
        $dateInterval = $interval->format('%R%y year(s) %m month(s) %d day(s) %h hour(s) : %i minute(s)');

        return $this->render('offer/show.html.twig', [
            'offer'        => $offer,
            'dateInterval' => $dateInterval,
        ]);
    }
}
