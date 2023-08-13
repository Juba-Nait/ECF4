<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/produits', name: 'admin_products_')]

class ProductsController extends AbstractController
{
    //la route qui a une methode et qui renvoie une vue
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/products/index.html.twig');
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        // on crée un "nouveau produit"
        $product = new Products();

        // on crée le formulaire
        $productform = $this->createForm(ProductsFormType::class, $product);

        // on traite la requete du formulaire
        $productform->handleRequest($request);
        // on vérifie si le formulaire est soumis et valide
        if ($productform->isSubmitted() && $productform->isValid()) {
            // on génere l'id

            // on arrondit le prix
            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);
            // on stock
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit ajouté avce succès');
            //On redirige
            return $this->redirectToRoute('admin_products_index');
        }
        return $this->render('admin/products/add.html.twig', [
            'productform' => $productform->createView()
        ]);






        // ou cette methode:

        // return $this->renderForm('admin/products/add.html.twig', compact('productForm'));
        // ['productForm' => $productForm]      "la meme chose que compact"
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Products $product, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        //on verifie si l'utilisateur peut éditer avec le voter
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

        //on divise le prix par 100
        $prix = $product->getPrice() / 100;
        $product->setPrice($prix);

        // on crée le formulaire
        $productform = $this->createForm(ProductsFormType::class, $product);

        // on traite la requete du formulaire
        $productform->handleRequest($request);
        // on vérifie si le formulaire est soumis et valide
        if ($productform->isSubmitted() && $productform->isValid()) {
            // on génere l'id

            // on arrondit le prix
            $prix = $product->getPrice() * 100;
            $product->setPrice($prix);
            // on stock
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Produit modifié avce succès');
            //On redirige
            return $this->redirectToRoute('admin_products_index');
        }
        return $this->render('admin/products/edit.html.twig', [
            'productform' => $productform->createView()
        ]);



        return $this->render('admin/products/index.html.twig');
    }
    //on verifie si l'utilisateur peut supprimer avec le voter
    #[Route('/suppression/{id}', name: 'delete')]
    public function delete(Products $product): Response
    {
        return $this->render('admin/products/index.html.twig');
    }
}
