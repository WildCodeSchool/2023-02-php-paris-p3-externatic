<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Offer;
use App\Form\CandidateType;
use App\Repository\CandidateRepository;
use App\Form\SearchApplicationFilterType;
use App\Form\SearchOfferFilterType;
use App\Repository\ApplicationRepository;
use App\Repository\OfferRepository;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/candidate', name: 'candidate_')]
#[IsGranted('ROLE_CANDIDATE')]
class CandidateController extends AbstractController
{
    #[Route('/{id}/research', name: 'research', methods: ['GET'])]
    public function index(
        Request $request,
        OfferRepository $offerRepository,
        PaginatorInterface $paginator,
        Candidate $candidate,
    ): Response {
        $form = $this->createForm(SearchOfferFilterType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        $filters = $form->getData();
        $offers = $offerRepository->findwithFilter($filters);

        $offers = $paginator->paginate($offers, $request->query->getInt('page', 1), 6);

        return $this->render('candidate/research.html.twig', [
            'offers' => $offers,
            'now' => new DateTime(),
            'form' => $form,
            'candidate' => $candidate,
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, CandidateRepository $candidateRepository): Response
    {
        $user = $this->getUser();
        $candidate = $user->getCandidate();

        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->save($candidate, true);

            $this->addFlash('success', 'Your account has been created! :)');

            return $this->redirectToRoute(
                'candidate_research',
                [
                'id' => $candidate->getId()
                ],
                Response::HTTP_SEE_OTHER
            );
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Some mandatory elements are incomplete or missing. Please review your answers.');
        }

        return $this->render('candidate/new.html.twig', [
            'candidate' => $candidate,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET', 'POST'])]
    public function show(Candidate $candidate): Response
    {
        return $this->render('candidate/show.html.twig', [
            'candidate' => $candidate,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Candidate $candidate, Request $request, CandidateRepository $candidateRepository): Response
    {
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->save($candidate, true);

            $this->addFlash('success', 'Your account has been updated! :)');

            return $this->redirectToRoute('candidate_show', ['id' => $candidate->getId()], Response::HTTP_SEE_OTHER);
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Some mandatory elements are incomplete or missing. Please review your answers.');
        }

        return $this->render('candidate/edit.html.twig', [
            'candidate'  => $candidate,
            'form'       => $form,
        ]);
    }

    #[Route('/{id}/updateVisibility', name: 'visibility')]
    public function updateVisibility(CandidateRepository $candidateRepository, Candidate $candidate): Response
    {
        $candidate->setVisible(!($candidateRepository->findOneById($candidate->getId()))->isVisible());
        $candidateRepository->save($candidate, true);

        return $this->redirectToRoute('candidate_show', ['id' => $candidate->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Candidate $candidate, CandidateRepository $candidateRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $candidate->getId(), $request->request->get('_token'))) {
            $candidateRepository->remove($candidate, true);
        }

        return $this->redirectToRoute('candidate_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/applications', name: 'applications', methods: ['GET'])]
    public function applications(
        Request $request,
        Candidate $candidate,
        ApplicationRepository $applicationRepo,
        PaginatorInterface $paginator
    ): Response {
        $form = $this->createForm(SearchApplicationFilterType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);

        $applications = $applicationRepo->findByCandidate($candidate);

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData();
            $applications = $applicationRepo->findApplication($search, $candidate);
        }

        $applications = $paginator->paginate($applications, $request->query->getInt('page', 1), 6);

        return $this->render('candidate/applications.html.twig', [
            'candidate' => $candidate,
            'now' => new DateTime(),
            'applications' => $applications,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/addToFavorite', name: 'favorites', methods: ['GET', 'POST'])]
    public function addOfferToFavorites(
        CandidateRepository $candidateRepository,
        Offer $offer,
    ): Response {
        $candidate = $this->getUser()->getCandidate();

        $candidate->isOfferInFavorites($offer) ?
        $candidate->removeFavoriteOffer($offer) :
        $candidate->addFavoriteOffer($offer);

        $candidateRepository->save($candidate, true);

        $this->addFlash('success', 'The offer: ' . $offer->getTitle() . 'has been successfully added as favorite 😊');

        //Faire en sorte de rediriger vers la même route sur laquelle on est
        //+ ajout message flash quand on remove une offre des favories

        return $this->redirectToRoute(
            'candidate_research',
            [
            'offer' => $offer->getId(),
            'id' => $candidate->getId()
            ],
            Response::HTTP_SEE_OTHER
        );
    }

    #[Route('/{id}/collection', name: 'collection')]
    public function showCollection(
        Candidate $candidate,
        PaginatorInterface $paginator,
        Request $request
    ): Response {

        return $this->render('candidate/collection.html.twig', [
            'candidate' => $candidate,
            'offers' => $paginator->paginate($candidate->getFavoriteOffers(), $request->query->getInt('page', 1), 6),
            'now' => new DateTime(),
        ]);
    }
}
