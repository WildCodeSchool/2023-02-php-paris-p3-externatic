<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Offer;
use App\Entity\User;
use App\Entity\Company;
use App\Entity\Application;
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
        $offers = $paginator->paginate($offerRepository->findAll(), $request->query->getInt('page', 1), 5);

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
        $dateInterval =  $interval->format('%R%y year(s) %m month(s) %d day(s) %h hour(s) : %i minute(s)');

        return $this->render('offer/show.html.twig', [
            'offer'        => $offer,
            'dateInterval' => $dateInterval,
        ]);
    }

    // #[Route('/apply/{id}', name: 'apply', methods: ['GET', 'POST'])]
    // public function apply(Application $application, Request $request, EntityManagerInterface $manager): Response
    // {
    //     $application = new Application();
    //     $form = $this->createForm(ApplicationType::class, $application);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $application = $form->getData();
    //         //Pour le tuple de la table "application" nouvellement crée soit directement assignée à l'user courant
    //         $application->setUser($this->getUser());

    //         $manager->persist($application);
    //         $manager->flush();

    //         $this->addFlash(
    //             'success',
    //             'Vous avez bien postulé à l\'offre'
    //         );
    //         return $this->redirectToRoute('offer_index');
    //     }
    // }
}
