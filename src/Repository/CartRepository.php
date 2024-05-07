<?php


namespace App\Repository;

use App\Entity\Cart;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityMangerInterface;

class CartRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }
    public function findByUserIdAndProductId(int $userId, int $productId): array
    {
        try {
            $entityManager = $this->getEntityManager();
            $query = $entityManager->createQuery(
                'SELECT c FROM App\Entity\Cart c 
             WHERE c.idUser = :userId AND c.idProduct = :productId'
            )->setParameters([
                'userId' => $userId,
                'productId' => $productId,
            ]);

            return $query->getResult();
        } catch (\Exception $e) {
            // Handle any exceptions (e.g., logging, error messages)
            // For debugging purposes, you can also output the exception message
            echo 'Error executing query: ' . $e->getMessage();
            return []; // Return an empty array to indicate failure
        }
    }


    // You can add custom repository methods here
}