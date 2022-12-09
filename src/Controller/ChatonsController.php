<?php

namespace App\Controller;

use App\Entity\Chaton;
use App\Form\ChatonSupprimerType;
use App\Form\ChatonType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Categorie;

class ChatonsController extends AbstractController
{
    /**
     * @Route("/chatons/ajouter", name="app_chatons")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {

        $chaton = new Chaton();
        $form = $this->createForm(ChatonType::class, $chaton);

        //retour du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //l'objet catégorie est rempli
            //on va utiliser l'entity manager de doctrine
            //(capable de gérer des entités)
            $em = $doctrine->getManager();
            //on lui dit qu'on veut mettre la catégorie dans la table
            $em->persist($chaton);

            //on génère l'appel SQL (l'insert ici)
            $em->flush();

            //on revient à l'acceuil
            return $this->redirectToRoute("app_categories");
        }

        return $this->render('chatons/index.html.twig', [
            'controller_name' => 'ChatonsController',
            "formulaire" => $form->createView()
        ]);
    }



    /**
     * @Route("/voir/{id}", name="app_chatons_voir")
     */
    public function afficher($id, ManagerRegistry $doctrine, Request $request)
    {
        $categorie = $doctrine->getRepository(Categorie::class)->find($id);
        $chatons = $categorie->getChatons();



        return $this->render('chatons/voir.html.twig', [
            'nomDuDossier' => $categorie->getTitre(),
            "chatons"=>$chatons
        ]);
    }

    /**
     * @Route("/supr/{id}", name="app_chatons_supr")
     */
    public function supr($id, ManagerRegistry $doctrine, Request $request)
    {

        $chat = $doctrine->getRepository(Chaton::class)->find($id);

        //404
        if (!$chat){
            throw $this->createAccessDeniedException("pas de catégories avec l'id $id");
        }
        $form = $this->createForm(ChatonSupprimerType::class, $chat);

        //retour
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->remove($chat);
            $em->flush();

            //on revient à l'acceuil
            return $this->redirectToRoute("app_categories");
        }



        return $this->render('chatons/supprimer.html.twig', [
            "chat"=>$chat,
            "formulaire"=>$form->createView()
        ]);
    }
}
