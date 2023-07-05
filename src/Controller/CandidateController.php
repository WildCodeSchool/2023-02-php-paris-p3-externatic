<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Form\CandidateType;
use App\Form\UploadResumeType;
use App\Repository\CandidateRepository;
use Gedmo\Sluggable\Util\Urlizer;
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
        $candidate = new Candidate();
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->save($candidate, true);

            return $this->redirectToRoute('candidate_index', [], Response::HTTP_SEE_OTHER);
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
            'action' => $this->generateUrl('candidate_edit_upload', ['id' => $candidate->getId()]),
            'method' => 'POST',
        ]);

        return $this->render('candidate/show.html.twig', [
            'candidate' => $candidate,
            'form' => $form,
        ]);
    }

    #[Route('/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Candidate $candidate, Request $request, CandidateRepository $candidateRepository): Response
    {
        $form = $this->createForm(CandidateType::class, $candidate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $candidateRepository->save($candidate, true);

            return $this->redirectToRoute('candidate_show', ['id' => $candidate->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('candidate/new.html.twig', [
            'candidate' => $candidate,
            'form' => $form
        ]);
    }

    #[Route('/{id}/edit/upload', name: 'edit_upload', methods: ['GET', 'POST'])]
    public function editUpload(Request $request, Candidate $candidate, CandidateRepository $candidateRepository): Response
    {
        //Form edit/upload picture
        $formUploadResume = $this->createForm(UploadResumeType::class, $candidate);

        if ($request->isMethod('POST')) {
            $formUploadResume->handleRequest($request);

            if ($formUploadResume->isSubmitted() && $formUploadResume->isValid()) {
                $uploadedFile = $formUploadResume['file']->getData();

                if ($uploadedFile) {
                    $destination = $this->getParameter("kernel.project_dir") . Candidate::UPLOAD_REPOSITORY;
                    $pathinfo = $uploadedFile->getClientOriginalName();
                    $extension = $uploadedFile->guessExtension();
                    $newFileName = Urlizer::urlize(pathinfo($pathinfo, PATHINFO_FILENAME)) . "-" . uniqid() . "." . $extension;

                    $uploadedFile->move($destination, $newFileName);

                    $candidate->setResume($newFileName);
                }

                $candidateRepository->save($candidate, true);

                return $this->redirectToRoute('candidate_show', ['id' => $candidate->getId()], Response::HTTP_SEE_OTHER);
            }
        }

        return $this->render('candidate/edit.html.twig', [
            'candidate' => $candidate,

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
}
