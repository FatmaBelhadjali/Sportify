<?php

namespace App\Repository;

use App\Entity\Utilisateurs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Utilisateurs>
* @implements PasswordUpgraderInterface<Utilisateurs>
 *
 * @method Utilisateurs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateurs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateurs[]    findAll()
 * @method Utilisateurs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateursRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utilisateurs::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof Utilisateurs) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }


    public function findBySearch($search)
    {
        $queryBuilder = $this->createQueryBuilder('u');

        if ($search) {
            $queryBuilder->andWhere('u.pseudo LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function findOneByEmail($search)
    {
        $queryBuilder = $this->createQueryBuilder('u');

        if ($search) {
            $queryBuilder->andWhere('u.email LIKE :search')
                ->setParameter('search', '%'.$search.'%');
        }

        return $queryBuilder->getQuery()->getResult();
    }


    public function countUsersByRole(): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('roles', 'roles');
        $rsm->addScalarResult('count', 'count');

        $query = $this->getEntityManager()->createNativeQuery('
        SELECT roles, COUNT(*) as count
        FROM utilisateurs
        GROUP BY roles
    ', $rsm);

        return $query->getResult();
    }

    public function countVerificationStatus(): array
    {
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('verification_status', 'verification_status');
        $rsm->addScalarResult('count', 'count');

        $query = $this->getEntityManager()->createNativeQuery('
            SELECT is_verified AS verification_status, COUNT(*) AS count
            FROM utilisateurs
            GROUP BY is_verified
        ', $rsm);

        return $query->getResult();
    }


//    /**
//     * @return Utilisateurs[] Returns an array of Utilisateurs objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Utilisateurs
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
