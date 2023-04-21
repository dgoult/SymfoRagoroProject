<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Intervenant;
use App\Entity\Matiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class CoursFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('date_cours', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('heure_debut', TimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('heure_fin', TimeType::class, [
                'widget' => 'single_text'
            ])
            ->add('Intervenant', EntityType::class, [
                'class' => Intervenant::class,
                'choice_label' => 'FullName'
            ])
            ->add('Matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'intitule'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
