<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProStageController extends AbstractController
{
    /**
     * @Route("/", name="pro_stage")
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
        return $this->render('pro_stage/index.html.twig', [
            'controller_name' => 'ProStageController',
            'ressourcesStages' => $ressourcesStages,
            'ressourcesFormations' => $ressourcesFormations,
            'ressourcesEntreprises' => $ressourcesEntreprises,
        ]);}
    /**
     * @Route("/entreprises/{id}", name="entreprises")
     */
    public function entreprises($id) 
    {
        // Récupérer les repository des entités Stage et Entreprise
       $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
       $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

       // Récupérer les ressources enregistrées en BD
       $ressourcesStagesParEntreprise = $repositoryStages->findBy(["Entreprise" => $id]);
       $ressourcesEntreprise = $repositoryEntreprise->find($id);

        return $this->render('pro_stage/Entreprises.html.twig', [
            'controller_name' => 'entreprisesController',
            'ressourcesStagesParEntreprise' => $ressourcesStagesParEntreprise, 
            'ressourcesEntreprise' => $ressourcesEntreprise]);}
    /**
     * @Route("/formations/{id}", name="formations")
     */
    public function formations($id) 
    {
        // Récupérer les repository des entités Stage et Formation
        $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
        $repositoryFormations = $this->getDoctrine()->getRepository(Formation::class);

        // Récupérer les ressources enregistrées en BD
        $ressourcesStagesParFormation = $repositoryStages->findAll();
        $ressourcesFormation = $repositoryFormations->find($id);

        // Récupérer les formations des stages correspondant à la bonne formation
        $lesStages = $ressourcesFormation->getFormations();

        return $this->render('pro_stage/Formations.html.twig',[
            'controller_name' => 'FormationController',
            'ressourcesStagesParFormation' => $ressourcesStagesParFormation, 
            'ressourcesFormation' => $ressourcesFormation, 
            'lesStages' => $lesStages]);}

    /**
     * @Route("/stages/{id}", name="stages")
     */
    public function stages($id) 
    {
        $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
        $ressourceStage = $repositoryStages->find($id);

        // Récupérer les formations du stage
        $lesFormations = $ressourceStage->getFormation();

        return $this->render('pro_stage/stages.html.twig',['controller_name' => 'StageController',
        'ressourceStage' => $ressourceStage,
        'lesFormations' => $lesFormations, ] );}


}
