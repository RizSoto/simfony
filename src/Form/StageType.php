<?php

namespace App\Form;

use App\Entity\Stage;
use App\Entity\Formation;
use App\Entity\Entreprise;
use App\Form\FormationType;
use App\Form\EntrepriseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class)
            ->add('description', TextareaType::class)
            ->add('email', TextType::class)
            ->add('Entreprise', EntrepriseType::class)
            ->add('Formation',EntityType::class,array(
            'class'=>Formation::class,
            'choice_label'=>'nomLong',
            
            'multiple'=>true,
            'expanded'=>true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
