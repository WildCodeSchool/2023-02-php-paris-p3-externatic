<?php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Offer>
 *
 * @method Offer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Offer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Offer[]    findAll()
 * @method Offer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Offer::class);
    }

    public function save(Offer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Offer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLikeTitle(string $title): ?array
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->where('o.title LIKE :title')
            ->setParameter('title', '%' . $title . '%')
            ->orderBy('o.title', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }

    public function findLikeLocation(string $location): ?array
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->where('o.location LIKE :location')
            ->setParameter('location', '%' . $location . '%')
            ->orderBy('o.title', 'ASC')
            ->getQuery();

        return $queryBuilder->getResult();
    }
}
