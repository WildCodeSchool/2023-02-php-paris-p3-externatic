<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Offer;
use App\Form\CandidateType;
use App\Form\UploadResumeType;
use App\Repository\CandidateRepository;
use App\Form\SearchApplicationFilterType;
use App\Repository\ApplicationRepository;
use App\Repository\OfferRepository;
use Knp\Component\Pager\PaginatorInterface;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/candidate', name: 'candidate_')]
class CandidateController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(CandidateRepository $candidateRepository): Response
    {
        return $this->render('candidate/index.html.twig', [
            'candidates' => $candidateRepository->findAll(),
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

            return $this->redirectToRoute('home_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidate/new.html.twig', [
            'candidate' => $candidate,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET', 'POST'])]
    public function show(Candidate $candidate): Response
    {
        $form = $this->createForm(UploadResumeType::class, $candidate, [
            'action' => $this->generateUrl('candidate_edit', ['id' => $candidate->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('candidate/show.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Candidate $candidate, Request $request, CandidateRepository $candidateRepository): Response
    {
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        $formUpload = $this->createForm(UploadResumeType::class, $candidate);
        $formUpload->handleRequest($request);

        if ($formUpload->isSubmitted() && $formUpload->isValid()) {
            $candidateRepository->save($candidate, true);

            $this->addFlash('success', 'Your resume has been uploaded! :)');

            return $this->redirectToRoute('candidate_show', ['id' => $candidate->getId()], Response::HTTP_SEE_OTHER);
        } elseif ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->save($candidate, true);

            $this->addFlash('success', 'Your account has been updated! :)');

            return $this->redirectToRoute('candidate_show', ['id' => $candidate->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->render('candidate/edit.html.twig', [
            'candidate'  => $candidate,
            'formUpload' => $formUpload,
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
        Offer $offer
    ): Response {
        $candidate = $this->getUser()->getCandidate();

        $candidate->isOfferInFavorites($offer) ?
        $candidate->removeFavoriteOffer($offer) :
        $candidate->addFavoriteOffer($offer);

        $candidateRepository->save($candidate, true);

        //changer la redirection vers la page candidate_research
        return $this->redirectToRoute('home_index', ['offer' => $offer->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/collection', name: 'collection')]
    public function showCollection(
        Candidate $candidate,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $offers = $candidate->getFavoriteOffers();

        $offers = $paginator->paginate($offers, $request->query->getInt('page', 1), 6);

        return $this->render('candidate/collection.html.twig', [
            'candidate' => $candidate,
            'offers' => $offers,
            'now' => new DateTime(),
        ]);
    }
}
