<?php

namespace App\Twig\Components;

use App\Repository\OfferRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('offer')]
final class OffersByCompanyComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $search = '';

    public function __construct(private OfferRepository $repository, private Security $security)
    {
    }

    public function searchOfferByCompany(): ?array
    {
        return $this->repository->searchOffersByCompany($this->security->getUser()->getCompany()->getId(), $this->search);
    }
}
