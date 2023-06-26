<?php

namespace App\Repository;

use App\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter as Parameter;
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

    public function findwithFilter(array $data): ?array
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->select('o', 'c')
            ->join('o.company', 'c');

            if (!empty($data['searchTitle'])) {
                $queryBuilder = $queryBuilder
                    ->andWhere('o.title Like :title')
                    ->setParameter('title', '%' . $data['searchTitle'] . '%');
            }

            if (!empty($data['searchLocation'])) {
                $queryBuilder = $queryBuilder
                    ->andWhere('o.location LIKE :location')
                    ->setParameter('location', '%' . $data['searchLocation'] . '%');
            }
            
            if (!empty($data['contract'])) {
                $queryBuilder = $queryBuilder
                    ->andWhere('o.contract = :contract')
                    ->setParameter('contract', $data['contract']);
            }

            if (!empty($data['companySector'])) {
                $queryBuilder = $queryBuilder
                    ->andWhere('c.sector IN (:sector)')
                    ->setParameter('sector', $data['companySector']);
            }

            if (!empty($data['experience'])) {
                $queryBuilder = $queryBuilder
                    ->andWhere('o.experience IN (:experience)')
                    ->setParameter('experience', $data['experience']);
            }

            if (!empty($data['workFromHome'])) {
                $queryBuilder = $queryBuilder
                    ->andWhere('o.workFromHome IN (:workFromHome)')
                    ->setParameter('workFromHome', $data['workFromHome']);
            }

            if (!empty($data['salary'])) {
                $queryBuilder = $queryBuilder
                    ->andWhere('o.minSalary < :salary AND o.maxSalary > :salary')
                    ->setParameter('salary', $data['salary']);
            }

            $queryBuilder = $queryBuilder
                ->orderBy('o.title', 'ASC')
                ->getQuery();

        return $queryBuilder->getResult();
    }
}
