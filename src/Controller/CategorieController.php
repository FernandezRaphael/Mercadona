<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieFormType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(CategorieRepository $categorieRepository): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categorie' => $categorieRepository->findBy([])
        ]);
    }

    #[Route('/ajoutCategorie', name: 'add_categorie')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        //on crée une nouvelle categorie
        $categorie = new Categorie();

        //on crée le formulaire
        $categorieForm = $this->createForm(CategorieFormType::class, $categorie);
        //on traite la requête du formulaire
        $categorieForm->handleRequest($request);
        
        //on vérifie si le formulaire est soumis et valide
        if($categorieForm->isSubmitted() && $categorieForm->isValid()){
            
            $em->persist(($categorie));
            $em->flush();
            $this->addFlash('success', 'Catégorie ajouté avec succès !');
            return $this->redirectToRoute(('add_categorie'));
        }

        return $this->render('categorie/index.html.twig',[
            'categorieForm' => $categorieForm->createView() ]);
    }

}
