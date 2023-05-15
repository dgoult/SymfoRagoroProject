<?php

namespace App\Form;

use App\Entity\Intervenant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IntervenantFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('civilite', TextType::class, [
                'mapped' => false
            ])
            ->add('nom', TextType::class, [
                'mapped' => false
            ])
            ->add('prenom', TextType::class, [
                'mapped' => false
            ])
            ->add('email', TextType::class, [
                'mapped' => false
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false
            ])
            ->add('specialite_professionnelle', TextType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervenant::class,
        ]);
    }
}
