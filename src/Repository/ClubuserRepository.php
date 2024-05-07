<?php

namespace App\Repository;

use App\Entity\Clubuser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Clubuser>
 *
 * @method Clubuser|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clubuser|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clubuser[]    findAll()
 * @method Clubuser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClubuserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clubuser::class);
    }

//    /**
//     * @return Clubuser[] Returns an array of Clubuser objects
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

//    public function findOneBySomeField($value): ?Clubuser
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
