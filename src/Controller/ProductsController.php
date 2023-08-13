<?php

namespace App\Controller;

use App\Entity\Products;
//use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig');
    }
    #[Route('/{id}', name: 'details')]
    // #[ParamConverter('product', class: 'App\Entity\Products')]
    public function details(Products $product): Response
    {
        //dd($product);
        return $this->render('products/details.html.twig', [
            'product' => $product
        ]);



        // compact('product'));
    }
}
