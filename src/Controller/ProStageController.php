<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\StageRepository;
use App\Entity\EntrepriseRepository;
use App\Entity\FormationRepository;

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
     * @Route("/ajoutEntreprise", name="ajoutEntreprise")
     */
    public function ajoutEntreprise(): Response
    {//Création d'une ressource vierge qui sera remplie par le formulaire
        $entreprise = new Entreprise();

        // Création du formulaire permettant de saisir une ressource
        $formulaireEntreprise = $this->createForm(EntrepriseType::class, $entreprise);

        /* On demande au formulaire d'analyser la dernière requête Http. Si le tableau POST contenu
        dans cette requête contient des variables titre, descriptif, etc. alors la méthode handleRequest()
        récupère les valeurs de ces variables et les affecte à l'objet $ressource*/
        $formulaireEntreprise->handleRequest($request);

         if ($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
         {
            // Mémoriser la date d'ajout de la ressources
            $entreprise->setDateAjout(new \dateTime());
            // Enregistrer la ressource en base de donnéelse
            $manager->persist($entreprise);
            $manager->flush();

            // Rediriger l'utilisateur vers la page d'accueil
            return $this->redirectToRoute('pro_stage');
         }

        // Afficher la page présentant le formulaire d'ajout d'une ressource
        return $this->render('pro_stage/ajoutEntreprise.html.twig',['vueFormulaire' => $formulaireEntreprise->createView(), 'action'=>"ajouter"]);}
    /**
     * @Route("/entreprises/{nom}", name="entreprises")
     */
    public function entreprises($nom) 
    {
        // Récupérer les repository des entités Stage et Entreprise
       $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
       $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

       // Récupérer les ressources enregistrées en BD
       //$ressourcesStagesParEntreprise = $repositoryStages->findBy(["Entreprise" => $id]);
       $ressourcesEntreprise = $repositoryEntreprise->find($nom); 
       $ressourcesStagesParEntreprise = $repositoryStages->findByEntreprise([$nom]);
        return $this->render('pro_stage/Entreprises.html.twig', [
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
            'lesStages' => $lesStages]);
        }

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
        'ressourceStage' => $ressourceStage ] );}

    /**
     * @Route("/StageParNomEntreprise/{nom}", name="listeStage_ParNomEntreprise")
     */
    public function listeStageParNomEntreprise(StageRepository $repositoryStage, $nom) 
    {
        
        $ressourceStage = $repositoryStage->findByEntreprise($nom);

        return $this->render('pro_stage/stages.html.twig',
        ['ressourceStage' => $ressourceStage ] );
    }
}
