<?php

namespace App\Controller;

use App\Form\SearchOfferFilterType;
use App\Entity\Offer;
use App\Entity\Application;
use App\Entity\Skill;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use App\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/offer', name: 'offer_')]
class OfferController extends AbstractController
{
    #[Route('/show/{id}', name: 'show', methods: ['GET', 'POST'])]
    public function show(Offer $offer, ApplicationRepository $applyRepository): Response
    {
        $interval = date_diff(new DateTime(), $offer->getCreatedAt());
        $dateInterval = $interval->format('%m month(s) and %d day(s)');

        $applied = false;
        if ($this->getUser()) {
            $candidate = $this->getUser()->getCandidate();
            if ($applyRepository->findOneBy(array('offer' => $offer,'candidate' => $candidate))) {
                $applied = true;
            }
        }
        

        return $this->render('offer/show.html.twig', [
            'offer'        => $offer,
            'dateInterval' => $dateInterval,
            'applied'      => $applied,
        ]);
    }

    #[Route('/apply/{id}', name: 'apply', methods: ['GET'])]
    #[IsGranted('ROLE_CANDIDATE')]
    public function applyOffer(Offer $offer, ApplicationRepository $applyRepository): Response
    {
        $applyRepository->apply($offer, $this->getUser()->getCandidate());

        return $this->redirectToRoute('offer_show', ['id' => $offer->getId()]);
    }
}
