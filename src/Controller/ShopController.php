<?php

namespace App\Controller;

use App\Entity\Produit;

use App\Repository\ProduitRepository;
use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\User;
use App\Entity\Utilisateurs;

#[Route('/shop')]
class ShopController extends AbstractController
{
    #[Route('/', name: 'app_shop_index', methods: ['GET'])]
    #[Route('/product/{id}', name: 'app_shop_product_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function index(ProduitRepository $productRepository, Produit $product = null, Request $request, PaginatorInterface $paginator): Response
    {
        if ($product) {
            return $this->render('shop/show.html.twig', [
                'produit' => $product,
            ]);
        }

        $products = $paginator->paginate(
            $productRepository->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('shop/shop.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/search", name="search", methods={"GET"})
     */
    /**
     */
    #[Route('/add_to_cart/{productId}', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(Request $request, EntityManagerInterface $entityManager, $productId, CartRepository $cartRepository): Response
    {
        // Retrieve the product entity based on the product ID
        $product = $this->getDoctrine()->getRepository(Produit::class)->find($productId);

        // Check if the user is authenticated
      

        // Create a new Cart entity
        try {
            $this->insertIntoCartTable($entityManager, 1, $product->getId());

            // Retrieve carts based on user ID and product ID
            $carts = $cartRepository->findByUserIdAndProductId(1, $product->getId());

        } catch (\Exception $e) {
            // Log the error for debugging purposes
            if (isset($logger)) {
                $logger->error('Error adding to cart: ' . $e->getMessage());
            } else {
                // If logger is not available, echo the error for debugging
                echo 'Error adding to cart: ' . $e->getMessage();
            }

            // Render an error template indicating failure
            return $this->render('error.html.twig', ['message' => 'Failed to add to cart']);
        }

        // Render the cart template with success message and retrieved carts
        return $this->render('cart/index.html.twig', ['success' => true, 'carts' => $carts]);
    }
    public function insertIntoCartTable(EntityManagerInterface $entitymanager,$idUser,$idProduct)
    {

        $connection=$entitymanager->getConnection();
        $sql="INSERT INTO cart (idUser,idProduct) VALUES (:idUser,:idProduct)";
        $statement=$connection->prepare($sql);
        $statement->bindValue('idUser' , $idUser);
        $statement->bindValue('idProduct' , $idProduct);
        $statement->execute();

    }
}
