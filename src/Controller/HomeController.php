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

#[Route('/', name:'home')]
class HomeController extends AbstractController
{
    #[Route('/home', name:'_index', methods: ['GET'])]
    public function home(
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

    #[Route('/', name:'', methods: ['GET'])]
    public function redirection(): Response
    {
        if ($this->getUser()) {
            $roles = $this->getUser()->getRoles();
            if (in_array('ROLE_CANDIDATE', $roles)) {
                return $this->redirectToRoute('candidate_research', [
                    'id' => $this->getuser()->getCandidate()->getId()
                ]);
            } elseif (in_array('ROLE_COMPANY', $roles)) {
                return $this->redirectToRoute('company_offers', ['id' => $this->getuser()->getCompany()->getId()]);
            } else {
                return $this->redirectToRoute('home_index');
            }
        } else {
            return $this->redirectToRoute('home_index');
        }
    }
}
