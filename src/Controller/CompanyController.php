<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Candidate;
use App\Entity\Company;
use App\Form\ApplicationStatusType;
use App\Form\CompanyType;
use App\Repository\ApplicationRepository;
use App\Repository\CompanyRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/company', name: 'company_')]
#[IsGranted('ROLE_COMPANY')]
class CompanyController extends AbstractController
{
    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompanyRepository $companyRepository): Response
    {
        $company = $this->getUser()->getCompany();

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->save($company, true);

            $this->addFlash('success', 'Your account has been created! :)');

            return $this->redirectToRoute('company_offers', ['id' => $company->getId()], Response::HTTP_SEE_OTHER);
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Some mandatory elements are incomplete or missing. Please review your answers.');
        }

        return $this->render('company/new.html.twig', [
            'company' => $company,
            'form' => $form
        ]);
    }

    #[Route('/{id}/offers', name: 'offers')]
    public function indexOffers(Company $company): Response
    {
        return $this->render('company/indexOffer.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Company $company, Request $request, CompanyRepository $companyRepository): Response
    {
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->save($company, true);

            $this->addFlash('success', 'Your account has been updated! :)');

            return $this->redirectToRoute('company_offers', ['id' => $company->getId()], Response::HTTP_SEE_OTHER);
        } elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('danger', 'Some mandatory elements are incomplete or missing. Please review your answers.');
        }

        return $this->render('company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/candidate/application/{id}', name: 'candidate_application')]
    public function candidateApplication(
        Application $application,
        Request $request,
        ApplicationRepository $repository,
        MailerInterface $mailer
    ): Response {
        $form = $this->createForm(ApplicationStatusType::class, $application);
        $form->handleRequest($request);

        if ($application->getStatus() == Application::STATUS_RECEIVED) {
            $application->setStatus(Application::STATUS_INREVIEW);
            $repository->save($application, true);
        } elseif ($form->isSubmitted() && $form->isValid()) {
            $repository->save($application, true);

            if ($application->getMailMessage()) {
                $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($application->getCandidate()->getUser()->getLogin())
                ->cc($application->getOffer()->getCompany()->getUser()->getLogin())
                ->subject('you have received a reply to your application for offer ' . $application->getId())
                ->html($this->renderView('application/mail.html.twig', ['application' => $application]));

                $mailer->send($email);
            } elseif ($application->getStatus() == Application::STATUS_ACCEPTED) {
                $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($application->getCandidate()->getUser()->getLogin())
                ->cc($application->getOffer()->getCompany()->getUser()->getLogin())
                ->subject('you have received a reply to your application for offer ' . $application->getId())
                ->html($this->renderView('application/mailAccepted.html.twig', ['application' => $application]));

                $mailer->send($email);
            } elseif ($application->getStatus() == Application::STATUS_REJECTED) {
                $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($application->getCandidate()->getUser()->getLogin())
                ->cc($application->getOffer()->getCompany()->getUser()->getLogin())
                ->subject('you have received a reply to your application for offer ' . $application->getId())
                ->html($this->renderView('application/mailRefused.html.twig', ['application' => $application]));

                $mailer->send($email);
            }

            return $this->redirectToRoute('company_offers', [
                'id' => $application->getOffer()->getCompany()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('company/candidateApplication.html.twig', [
            'application' => $application,
            'company' => $application->getOffer()->getCompany(),
            'form' => $form,
        ]);
    }
}
