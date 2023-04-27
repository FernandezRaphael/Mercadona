<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Form\ProduitsFormType;
use App\Form\PromoFormType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitsController extends AbstractController
{
    #[Route('/produits', name: 'app_produits')]
    public function index(ProduitsRepository $produitsRepository, CategorieRepository $categorieRepository, Request $request): Response
    {
        $produits = new Produits();
       
        $filtre = $request->get("categorie");
       
        $produits = $produitsRepository->findAll();

        $produitfiltre = $produitsRepository->getProduitsfiltre($filtre);

        if($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('produits/_content.html.twig', compact('produitfiltre','produits'))
            ]);
        }

        $categories = $categorieRepository->findAll();

        return $this->render('produits/index.html.twig', compact('produits', 'categories'));
    }

    #[Route('/ajout', name: 'add_produits')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        //on crée un nouveau produit
        $produits = new Produits();

        //on crée le formulaire
        $produitsForm = $this->createForm(ProduitsFormType::class, $produits);

        //on traite la requête du formulaire
        $produitsForm->handleRequest($request);
        
        //on vérifie si le formulaire est soumis et valide
        if($produitsForm->isSubmitted() && $produitsForm->isValid()){

            $em->persist(($produits));
            $em->flush();

            return $this->redirectToRoute(('add_produits'));
        }
        

        return $this->render('produits/addproduits.html.twig',[
            'produitsForm' => $produitsForm->createView() ]);
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Produits $produits, Request $request, EntityManagerInterface $em): Response
    {
        //on crée le formulaire
        $produitsForm = $this->createForm(PromoFormType::class, $produits);

        //on traite la requête du formulaire
        $produitsForm->handleRequest($request);

        $promo = $produitsForm->get('Promotions')->getData();
        $prix = $produitsForm->get('prix')->getData();
        
        $promotionproduit = ($promo * $prix)/100;
        $promotionproduit = $prix - $promotionproduit;
        $produits->setNewPrix($promotionproduit);
        
        //on vérifie si le formulaire est soumis et valide
        if($produitsForm->isSubmitted() && $produitsForm->isValid()){

            $em->persist(($produits));
            $em->flush();

            return $this->redirectToRoute(('app_produits'));
        }
        
        return $this->render('promotions/index.html.twig',[
            'produitsForm' => $produitsForm->createView() ]);
    }

}