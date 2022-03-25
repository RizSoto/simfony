<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProstagesController extends AbstractController
{
    /**
     * @Route("/", name="Accueil")
     */
    public function index(): Response
    {
        // Récupérer le repository de Stage et récupération des données
        $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
        $ressourcesStages = $repositoryStages->findAll();

        // Récupérer le repository de Formation et récupération des données
        $repositoryFormations = $this->getDoctrine()->getRepository(Formation::class);
        $ressourcesFormations = $repositoryFormations->findAll();

        // Récupérer le repository de Entreprise et récupération des données
        $repositoryEntreprises = $this->getDoctrine()->getRepository(Entreprise::class);
        $ressourcesEntreprises = $repositoryEntreprises->findAll();

        return $this->render('Prostages/prostages.html.twig', [
            'controller_name' => 'to accueil',
            'ressourcesStages' => $ressourcesStages,
            'ressourcesFormations' => $ressourcesFormations,
            'ressourcesEntreprises' => $ressourcesEntreprises,
        ]);
    }
}