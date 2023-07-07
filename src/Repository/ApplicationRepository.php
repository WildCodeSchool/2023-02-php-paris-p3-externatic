<?php

namespace App\Repository;

use App\Entity\Application;
use App\Entity\Candidate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Application>
 *
 * @method Application|null find($id, $lockMode = null, $lockVersion = null)
 * @method Application|null findOneBy(array $criteria, array $orderBy = null)
 * @method Application[]    findAll()
 * @method Application[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Application::class);
    }

    public function save(Application $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Application $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findApplication(array $data, Candidate $candidate): ?array
    {
        $queryBuilder = $this->createQueryBuilder('a')
            ->select('o', 'a')
            ->join('a.offer', 'o')
            ->where('a.candidate = ' . $candidate->getId());

        if (!empty($data['searchTitleApplication'])) {
            $queryBuilder = $queryBuilder
                ->andWhere('o.title LIKE :title')
                ->setParameter('title', '%' . $data['searchTitleApplication'] . '%');
        }

        if (!empty($data['statusApplication'])) {
            $queryBuilder = $queryBuilder
                ->andWhere('a.status IN (:status)')
                ->setParameter('status', $data['statusApplication']);
        }

        $queryBuilder = $queryBuilder
            ->orderBy('o.createdAt', 'DESC')
            ->getQuery();

        return $queryBuilder->getResult();
    }
}
