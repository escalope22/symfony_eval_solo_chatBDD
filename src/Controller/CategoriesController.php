<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieSupprimerType;
use App\Form\CategorieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/", name="app_categories")
     */
    public function index(ManagerRegistry $doctrine_registry): Response
    {
        //||\\     -DOCTRINE-     //||\\
        //on va chercher les catégories dans la base
        //pour cela besoin d'un repository
        $repo = $doctrine_registry->getRepository(Categorie::class);
        //on récupère a partir du repo toutes les lignes dans la ligne categories
        $categories = $repo->findAll();

        return $this->render('categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
            'categories' => $categories,
        ]);
    }


    /**
     * @Route ("/categorie/ajouter", name="app_categories_ajouter")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {

        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);

        //retour du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //l'objet catégorie est rempli
            //on va utiliser l'entity manager de doctrine
            //(capable de gérer des entités)
            $em = $doctrine->getManager();
            //on lui dit qu'on veut mettre la catégorie dans la table
            $em->persist($categorie);

            //on génère l'appel SQL (l'insert ici)
            $em->flush();

            //on revient à l'acceuil
            return $this->redirectToRoute("app_categories");
        }

        return $this->render("categories/ajouter.html.twig", [
            "formulaire" => $form->createView()
        ]);
    }


    /**
     * @Route("/categorie/modifier/{id}", name="app_categories_modifier")
     */
    public function modifier($id, ManagerRegistry $doctrine, Request $request): Response{
        //créer le formulaire sur le même principe que dans ajouter
        //mais avec une categorie existante
        $categorie = $doctrine->getRepository(Categorie::class)->find($id);

        //si l'id n'existe pas
        if (!$categorie){
            throw $this->createAccessDeniedException("pas de catégories avec l'id $id");
        }
        $form = $this->createForm(CategorieType::class, $categorie);

        //retour du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //l'objet catégorie est rempli
            //on va utiliser l'entity manager de doctrine
            //(capable de gérer des entités)
            $em = $doctrine->getManager();
            //on lui dit qu'on veut mettre la catégorie dans la table
            $em->persist($categorie);

            //on génère l'appel SQL (update ici)
            $em->flush();

            //on revient à l'acceuil
            return $this->redirectToRoute("app_categories");
        }

        return $this->render("categories/modifier.html.twig",[
            "categorie"=>$categorie,
            "formulaire"=>$form->createView()
        ]);

    }


    /**
     * @Route("/categorie/supprimer/{id}", name="app_categories_supprimer")
     */
    public function supprimer($id, ManagerRegistry $doctrine, Request $request): Response{
        //créer le formulaire sur le même principe que dans ajouter
        //mais avec une categorie existante
        $categorie = $doctrine->getRepository(Categorie::class)->find($id);

        //si l'id n'existe pas
        if (!$categorie){
            throw $this->createAccessDeniedException("pas de catégories avec l'id $id");
        }
        $form = $this->createForm(CategorieSupprimerType::class, $categorie);

        //retour du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //l'objet catégorie est rempli
            //on va utiliser l'entity manager de doctrine
            //(capable de gérer des entités)
            $em = $doctrine->getManager();
            //on lui dit qu'on veut mettre la catégorie dans la table
            $em->remove($categorie);

            //on génère l'appel SQL (update ici)
            $em->flush();

            //on revient à l'acceuil
            return $this->redirectToRoute("app_categories");
        }

        return $this->render("categories/supprimer.html.twig",[
            "categorie"=>$categorie,
            "formulaire"=>$form->createView()
        ]);

    }
}

