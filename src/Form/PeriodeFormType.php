<?php

namespace App\Form;

use App\Entity\Periode;
use App\Enum\PeriodeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PeriodeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class)
            ->add('date_debut', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('date_fin', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('type', EnumType::class, [
                'class' => PeriodeType::class,
                'choice_label' => fn ($choice) => match ($choice) {
                    PeriodeType::ENTREPRISE => 'Entreprise',
                    PeriodeType::FORMATION => 'Formation',
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Periode::class,
        ]);
    }
}
