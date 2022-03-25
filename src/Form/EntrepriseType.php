<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        -> add('activite', ChoiceType::class,
        array(
                'choices' => array(
                    'Administration' => 'Administration',
                    'Aéronautique' => 'Aéronautique',
                    'Aéronavale' => 'Aéronavale',
                    'Agroalimentaire' => 'Agroalimentaire',
                    'Algorithmie' => 'Algorithmie',
                    'Arithmétiques' => 'Arithmétiques',
                    'Arts' => 'Arts',
                    'Assurance' => 'Assurance',
                    'Automobile' => 'Automobile',
                    'Biochimie' => 'Biochimie',
                    'Bois' => 'Bois',
                    'Chaussures' => 'Chaussures',
                    'Chaussures' => 'Chaussures',
                    'Chimie' => 'Chimie',
                    'Communication' => 'Communication',
                    'Conception' => 'Conception',
                    'Création graphique' => 'Création graphique',
                    'Développement' => 'Développement',
                    'Distribution' => 'Distribution',
                    'Droit' => 'Droit',
                    'Édition' => 'Édition',
                    'Électronique' => 'Électronique',
                    'Électricité' => 'Électricité',
                    'Énergie' => 'Énergie',
                    'Études' => 'Études',
                    'Fonction publique' => 'Fonction publique',
                    'Immobilier' => 'Immobilier',
                    'Imprimerie' => 'Imprimerie',
                    'Industrie pharmaceutique' => 'Industrie pharmaceutique',
                    'Logistique' => 'Logistique',
                    'Machines et équipements' => 'Machines et équipements',
                    'Métallurgie' => 'Métallurgie',
                    'Multimédia' => 'Multimédia',
                    'Plastique' => 'Plastique',
                    'Programmation' => 'Programmation',
                    'Restauration' => 'Restauration',
                    'Santé' => 'Santé',
                    'Services aux entreprises' => 'Services aux entreprises',
                    'Sports' => 'Sports',
                    'Télécoms' => 'Télécoms',
                    'Textile' => 'Textile',
                    'Tourisme' => 'Tourisme',
                    'Transports' => 'Transports',
                    'Université' => 'Université',
            )))
        -> add('adresse', TextType::class)
        -> add('nom', TextType::class)
        -> add('urlSite', UrlType::class)
        //->add('stage')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
