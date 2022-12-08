<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Chaton;
use App\Entity\Proprietaire;
use App\Form\ProprietaireType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProprietairesController extends AbstractController
{
    /**
     * @Route("/proprietaires", name="app_proprietaires")
     */
    public function ajouter(ManagerRegistry $doctrine, Request $request): Response
    {
        $proprio = new Proprietaire();
        $formulaire = $this->createForm(ProprietaireType::class, $proprio);

        //retour
        $formulaire->handleRequest($request);
        if ($formulaire->isSubmitted() && $formulaire->isValid()){
            $em = $doctrine->getManager();
            $em->persist($proprio);

            $em->flush();

            return $this->redirectToRoute("app_categories");
        }
        return $this->render('proprietaires/ajouter.html.twig', [
            'controller_name' => 'ProprietairesController',
            'formulaire' => $formulaire->createView(),
        ]);
    }

    /**
     * @Route("/proprietaires/lié/{id}", name="app_lié")
     */
    public function lie($id, ManagerRegistry $doctrine_registry) : Response
    {
        $proprio = $doctrine_registry->getRepository(Proprietaire::class)->find($id);
        return $this->render('proprietaires/lie.html.twig', [
            'chats_proprio' => $proprio->getChatons(),
            'proprio' => $proprio,
            'chats' => $doctrine_registry->getRepository(Chaton::class)->findAll()
    ]);
    }

    /**
     * @Route("/proprietaires/lié/supr/{id_prop}{id_chat}", name="app_lié_supr")
     */
    public function supr_lie($id_prop, $id_chat, ManagerRegistry $doctrine_registry) : Response
    {
        $em=$doctrine_registry->getManager();
        $em->getRepository(Proprietaire::class)->find($id_prop)->removeChaton(
            $doctrine_registry->getRepository(Chaton::class)->find($id_chat)
        );
        $em->flush();

        return $this->redirectToRoute("app_lié",['id' => $id_prop]);
    }

    /**
     * @Route("/proprietaires/lié/add/{id_prop}{id_chat}", name="app_lié_add")
     */
    public function add_lie($id_prop, $id_chat, ManagerRegistry $doctrine_registry) : Response
    {
        $em=$doctrine_registry->getManager();
        $em->getRepository(Proprietaire::class)->find($id_prop)->addChaton(
            $doctrine_registry->getRepository(Chaton::class)->find($id_chat)
        );
        $em->flush();

        return $this->redirectToRoute("app_lié",['id' => $id_prop]);
    }
}
