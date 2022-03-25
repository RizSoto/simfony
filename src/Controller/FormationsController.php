<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formation;
use App\Entity\Stage;
use App\Form\FormationType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class FormationsController extends AbstractController
{
    /**
     * @Route("/formations/{nomCourt}", name="Formations")
     */
    public function index($nomCourt): Response
    {
        // Récupérer les repository des entités Stage et Formation
        $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
        $repositoryFormations = $this->getDoctrine()->getRepository(Formation::class);

        // Récupérer les ressources enregistrées en BD
        $ressourcesStagesParFormation = $repositoryStages->trouverStagesFormation($nomCourt);


        // Envoyer la ressource récupérée à la vue chargée de l'afficher
        return $this->render('formations/formations.html.twig', ['ressourcesStagesParFormation' => $ressourcesStagesParFormation,'nomFormation' => $nomCourt]);
    }

    /**
     * @Route("/ajouter_formation", name="AjoutFormation")
     */
    public function ajoutFormation(Request $requeteHttp, EntityManagerInterface $manager): Response
    {
        // Création d'une formation initialement vierge
        $formation = new Formation();

        // création d'un objet formulaire pour ajouter une formation
        $formulaireFormation=$this->createForm(FormationType::class, $formation);

            $formulaireFormation->handleRequest($requeteHttp);

            if($formulaireFormation->isSubmitted() && $formulaireFormation->isValid())
            {
                // Enregistrer la ressource en BD
                $manager->persist($formation);
                $manager->flush();
                // Rediriger l’utilisateur
                return $this->redirectToRoute('Accueil');
            }

            return $this->render('formations/ajouterFormation.html.twig', ['vueFormulaireFormation' => $formulaireFormation -> createView()]);
    }

}
