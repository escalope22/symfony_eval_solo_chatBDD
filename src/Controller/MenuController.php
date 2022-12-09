<?php

namespace App\Controller;

use App\Entity\Proprietaire;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Categorie;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class MenuController extends AbstractController
{
    public function _menu( ManagerRegistry $doctrine): Response
    {
        $categorie = $doctrine->getRepository(Categorie::class)->findAll();
        return $this->render('menu/_menu.html.twig', [
            'controller_name' => 'MenuController',
            "dossiers" => $categorie
        ]);
    }
    public function _menuProprio( ManagerRegistry $doctrine): Response
    {
        $categorie = $doctrine->getRepository(Proprietaire::class)->findAll();
        return $this->render('menu/_menuProprio.html.twig', [
            'controller_name' => 'MenuController',
            "proprio" => $categorie
        ]);
    }
}
