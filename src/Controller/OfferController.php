<?php

namespace App\Controller;

use App\Form\SearchOfferFilterType;
use App\Entity\Offer;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
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
            // $offers = $offerRepository->findAll();
        }

        $offers = $paginator->paginate($offerRepository->findAll(), $request->query->getInt('page', 1), 6);

        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
            'now' => new DateTime(),
            'form' => $form,
        ]);
    }

    #[Route('/show/{id}', name: 'show', methods: ['GET', 'POST'])]
    public function show(Offer $offer): Response
    {
        $interval = date_diff(new DateTime(), $offer->getCreatedAt());
        $dateInterval = $interval->format('%m month(s) and %d day(s)');

        return $this->render('offer/show.html.twig', [
            'offer'        => $offer,
            'dateInterval' => $dateInterval,
        ]);
    }

    #[Route('/form/new', name: 'form_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $offer = new Offer();
        $form = $this->createForm(Offer::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer = $form->getData();
            $offer->setCompany($this->getUser()->getCompany());

            $manager->persist($offer);
            $manager->flush();

            $this->addFlash(
                'succes',
                'Votre offre a été ajoutée avec succes'
            );

            return $this->redirectToRoute('offer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offer_type/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }
}
