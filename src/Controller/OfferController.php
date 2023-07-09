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

#[Route('/offer', name: 'offer_')]
class OfferController extends AbstractController
{
    #[Route('/index', name: 'index', methods: ['GET', 'POST'])]
    public function index(OfferRepository $offerRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $form = $this->createForm(SearchOfferFilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            $offers = $offerRepository->findwithFilter($filters);
        } else {
            $offers = $offerRepository->findAll();
        }

        $offers = $paginator->paginate($offerRepository->findAll(), $request->query->getInt('page', 1), 6);

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
            'now' => new DateTime(),
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET', 'POST'])]
    public function show(
        Offer $offer,
        ApplicationRepository $applyRepository,
        Request $request
    ): Response {
        $interval = date_diff(new DateTime(), $offer->getCreatedAt());
        $dateInterval = $interval->format('%m month(s) and %d day(s)');

        $form = $this->createForm(ApplicationType::class);
        $form->handleRequest($request);

        $applied = false;
        foreach ($this->getUser()->getCandidate()->getApplications() as $application) {
            if ($application->getOffer() == $offer) {
                $applied = true;
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $application = new Application();
            $application->setStatus("received")
                ->setCreatedAt(new DateTime('now'))
                ->setCandidate($this->getUser()->getCandidate())
                ->setOffer($offer);
            $applyRepository->save($application, true);
            return $this->redirectToRoute('offer_show', ['id' => $offer->getId()]);
        }

        return $this->render('offer/show.html.twig', [
            'offer'        => $offer,
            'dateInterval' => $dateInterval,
            'form'         => $form,
            'applied'      => $applied,
        ]);
    }
}
