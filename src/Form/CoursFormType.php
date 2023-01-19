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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('date_debut', DateTimeType::class)
            ->add('date_fin', DateTimeType::class)
            ->add('Intervenant', EntityType::class, [
                'class' => Intervenant::class,
                'choice_label' => 'nom'
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
