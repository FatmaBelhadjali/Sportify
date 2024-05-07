<?php

namespace App\Repository;

use App\Entity\Sponsor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\ResultSetMapping;
 
/**
 * @extends ServiceEntityRepository<Sponsor>
 *
 * @method Sponsor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sponsor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sponsor[]    findAll()
 * @method Sponsor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SponsorRepository extends ServiceEntityRepository
{
    public function findByNom($nom, $orderBy = null, $limit = null, $offset = null)
{
    $queryBuilder = $this->createQueryBuilder('s')
        ->andWhere('s.nom LIKE :nom')
        ->setParameter('nom', '%' . $nom . '%');

    if ($orderBy) {
        $queryBuilder->orderBy('s.' . key($orderBy), current($orderBy));
    }

    return $queryBuilder->getQuery()->getResult();
}

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sponsor::class);
    }

    
 public function getEventData(): array
 {
     $rsm = new ResultSetMapping();
     $rsm->addScalarResult('name', 'name');
     $rsm->addScalarResult('nbrParticipants', 'nbrParticipants');
     $rsm->addScalarResult('count', 'count');

     $query = $this->getEntityManager()->createNativeQuery('
     SELECT name, nbrParticipants, COUNT(*) as count
     FROM event
     GROUP BY name, nbrParticipants
 ', $rsm);

     return $query->getResult();
 }


//    /**
//     * @return Sponsor[] Returns an array of Sponsor objects
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

//    public function findOneBySomeField($value): ?Sponsor
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
