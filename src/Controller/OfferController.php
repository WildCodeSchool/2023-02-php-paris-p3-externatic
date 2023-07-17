<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\ApplicationRepository;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

    #[Route('/{id}/edit', name: 'form_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offer $offer, OfferRepository $offerRepository): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offerRepository->save($offer, true);

            $this->addFlash('success', 'Your offer has been succesfully edited 😉');

            return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('offer_type/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/form/new', name: 'form_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer = $form->getData();
            $offer->setCompany($this->getUser()->getCompany());

            $manager->persist($offer);
            $manager->flush();

            $this->addFlash(
                'success',
                'Your offer has been successfully added 😇 !'
            );

            return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('offer_type/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
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
