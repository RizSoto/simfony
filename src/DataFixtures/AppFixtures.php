<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Module pour générer des données aléatoires
        $faker = \Faker\Factory::create('fr_FR');

        //Tableaux de données pour avoir certaines données cohérentes
        $lesNomsEntreprises = array("Microsoft", "Apple", "Orange", "ProfEnPoche","Exakis", "Safran", "SFR", "AirBus","UPPA","MaireDeBayonne");
        $lesNomsFormations = array("DUT Informatique", "DUT GIM", "LP Programmation", "Master Physique","Master Informatique", "Master Système","INSA Rouens");
        $lesDiminutifsFormations = array("DUT Info", "DUT GIM", "LP Prog", "Mast Phy","Mast Info", "Mast Sys","INSA Rouens");
        $lesActivites = array("Programmation", "Algorithmie", "Conception", "Développement","Création graphique", "Électronique", "Physique","Arithmétiques");
        
        //Données pour la génération aléatoire d'un titre de stage
        $titre1 = array("Programmation", "Réalisation", "Conception", "Développement","Structuration", "Amélioration","Modification");
        $titre2 = array(" d'un site web", " d'une application web", " d'un programme", " d'une application", " d'une base de données", " d'un système", " d'une interface");
        $titre3 = array(" en Java.", " en Python.", " en C++.", " en CSS."," en Arduino.", " en C#.","en HTML","en PHP");
        
        //Tableau de recueil des données formations et entreprises
        $lesEntreprises=array();
        $lesFormations=array();

        //Génération des données des entreprises
        for($i=0; $i < count($lesNomsEntreprises); $i=$i+1)
        {
            $entreprise = new Entreprise();
            $entreprise->setActivite($lesActivites[rand(0,7)]);
            $entreprise->setAdresse($faker->streetAddress());
            $entreprise->setNom($lesNomsEntreprises[$i]);
            $entreprise->setUrlSite($faker->domainName());
            $lesEntreprises[$i]=$entreprise;    //Ajout des entreprises dans le tableau
            $manager->persist($entreprise);
        }

        //Génération des données des formations
        for($i=0; $i < count($lesNomsFormations); $i=$i+1)
        {
            $formation = new Formation();
            $formation->setNomLong($lesNomsFormations[$i]);
            $formation->setNomCourt($lesDiminutifsFormations[$i]);
            $lesFormations[$i]=$formation;    //Ajout des formations dans le tableau
            $manager->persist($formation);
        }

        //Génération des données des stages
        $nbStages = 20;

        for($i=1; $i <= $nbStages; $i=$i+1)
        {
            $stage = new Stage();
            $stage->setTitre($titre1[rand(0,6)].$titre2[rand(0,6)].$titre3[rand(0,7)]);
            $stage->setDescription($faker->realText($maxNbChars = 100, $indexSize = 2));
            $stage->setEmail($faker->safeEmail());
            $stage->setEntreprise($lesEntreprises[rand(0,9)]);
            $numFormation = $faker->numberBetween(0,6);
            $stage->addFormation($lesFormations[$numFormation]);


            $manager->persist($stage);
        }
        $manager->flush();
    }
}
