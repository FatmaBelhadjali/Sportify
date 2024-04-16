<?php

namespace App\Repository;

use App\Entity\Affiliation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Affiliation>
 *
 * @method Affiliation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Affiliation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Affiliation[]    findAll()
 * @method Affiliation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffiliationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affiliation::class);
    }

//    /**
//     * @return Affiliation[] Returns an array of Affiliation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Affiliation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
