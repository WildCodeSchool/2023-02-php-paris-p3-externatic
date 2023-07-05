<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/offer/form', name:'offer_form_')]
class OfferTypeController extends AbstractController
{
    #[Route('/', name: 'app_offer_type_index', methods: ['GET'])]
    public function index(OfferRepository $offerRepository): Response
    {
        return $this->render('offer_type/index.html.twig', [
            'offers' => $offerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer = $form->getData();
            $offer->setCompany($offer->getCompany());

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

    #[Route('/{id}', name: 'app_offer_type_show', methods: ['GET'])]
    public function show(Offer $offer): Response
    {
        return $this->render('offer_type/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_offer_type_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offer $offer, OfferRepository $offerRepository): Response
    {
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offerRepository->save($offer, true);

            return $this->redirectToRoute('app_offer_type_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offer_type/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_offer_type_delete', methods: ['POST'])]
    public function delete(Request $request, Offer $offer, OfferRepository $offerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $offerRepository->remove($offer, true);
        }

        return $this->redirectToRoute('app_offer_type_index', [], Response::HTTP_SEE_OTHER);
    }
}
