<?php

namespace App\Repository;

use App\Entity\CandidateMetadata;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CandidateMetadata>
 *
 * @method CandidateMetadata|null find($id, $lockMode = null, $lockVersion = null)
 * @method CandidateMetadata|null findOneBy(array $criteria, array $orderBy = null)
 * @method CandidateMetadata[]    findAll()
 * @method CandidateMetadata[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidateMetadataRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CandidateMetadata::class);
    }

    public function save(CandidateMetadata $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CandidateMetadata $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return CandidateMetadata[] Returns an array of CandidateMetadata objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CandidateMetadata
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
