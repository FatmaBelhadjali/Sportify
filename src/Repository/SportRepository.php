<?php

namespace App\Repository;

use App\Entity\Sport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sport>
 *
 * @method Sport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sport[]    findAll()
 * @method Sport[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sport::class);
    }
    public function findByKeyword($keyword)
    {
    return $this->createQueryBuilder('s')
        ->andWhere('s.description LIKE :keyword')
        ->setParameter('keyword', '%'.$keyword.'%')
        ->getQuery()
        ->getResult();
    }
    public function searchByType($query)
    {
    return $this->createQueryBuilder('s')
        ->andWhere('s.nom LIKE :query OR s.description LIKE :query')
        ->setParameter('query', '%' . $query . '%')
        ->orderBy('s.nom', 'ASC')
        ->getQuery()
        ->getResult();
    }
    public function searchByNom($query)
    {
    return $this->createQueryBuilder('s')
        ->andWhere('s.nom LIKE :query')
        ->setParameter('query', $query.'%')
        ->orderBy('s.nom', 'ASC')
        ->getQuery()
        ->getResult();
    }

//    /**
//     * @return Sport[] Returns an array of Sport objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sport
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
