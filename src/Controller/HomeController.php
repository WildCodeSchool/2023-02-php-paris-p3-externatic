<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\SearchOfferFilterType;
use App\Repository\OfferRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name:'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name:'index', methods: ['GET'])]
    public function index(
        Request $request,
        OfferRepository $offerRepository,
        PaginatorInterface $paginator,
    ): Response {
        $form = $this->createForm(SearchOfferFilterType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);
        $filters = $form->getData();
        $offers = $offerRepository->findwithFilter($filters);

        $offers = $paginator->paginate($offers, $request->query->getInt('page', 1), 6);

        return $this->render('home/index.html.twig', [
            'offers' => $offers,
            'now' => new DateTime(),
            'form' => $form,
        ]);
    }
}
