<?php

namespace App\Controller;

use App\Form\SearchOfferFilterType;
use App\Repository\OfferRepository;
use DateTime;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name:'home_')]
class HomeController extends AbstractController
{
    #[Route('/', name:'index', methods: ['GET'])]
    public function index(Request $request, OfferRepository $offerRepository, PaginatorInterface $paginator)
    {
        $form = $this->createForm(SearchOfferFilterType::class, null, ['method' => 'GET']);
        $form->handleRequest($request);
        $offers = $offerRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $filters = $form->getData();
            $offers = $offerRepository->findwithFilter($filters);
        }

        $offers = $paginator->paginate($offers, $request->query->getInt('page', 1), 6);

        return $this->render('home/index.html.twig', [
            'offers' => $offers,
            'now' => new DateTime(),
            'form' => $form,
        ]);
    }
}