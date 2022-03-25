<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Form\StageType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class StagesController extends AbstractController
{
    /**
     * @Route("/stages/{id}", name="stages")
     */
    public function index($id): Response
    {
        // Récupérer le repository de Stage et récupération du stage en particulier
        $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
        $ressourceStage = $repositoryStages->find($id);

        // Récupérer les formations du stage pour les afficher plus facilement dans la vue
        $lesFormations = $ressourceStage->getFormation();

        return $this->render('stages/stages.html.twig', [
            'controller_name' => 'StagesController',
            'ressourceStage' => $ressourceStage,
            'lesFormations' => $lesFormations,
        ]);
    }

    /**
     * @Route("/ajouter_stage", name="AjoutStage")
     */
    public function ajoutStage(Request $requeteHttp, EntityManagerInterface $manager): Response
    {
        // Création d'une ressource initialement vierge
        $stage = new Stage();

        // création d'un objet formulaire pour ajouter une entreprise
        $formulaireStage=$this->createForm(StageType::class, $stage);

            $formulaireStage->handleRequest($requeteHttp);

            if($formulaireStage->isSubmitted() && $formulaireStage->isValid())
            {
                // Enregistrer la ressource en BD
                $manager->persist($stage);
                $manager->persist($stage->getEntreprise());

                $manager->flush();
                // Rediriger l’utilisateur vers la page affichant la liste des ressources
                return $this->redirectToRoute('Accueil');
            }

            return $this->render('prostages/ajouterStage.html.twig', ['vueFormulaireStage' => $formulaireStage -> createView()]);
    }

}
