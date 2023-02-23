<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Sites;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('site', EntityType::class,
                [
                    'class' => Sites::class,
                    'placeholder' => '---------------------------',
                    'choice_label' => 'NomSite',
                    'required' => false,
                    'label' => 'Le site : '
                ])
            ->add('nom', options: [
                'required' => false,
                'label' => 'Le nom de la sortie contient : ',
            ])
            ->add('datedebut', type: DateType::class, options: [
                'required' => false,
                'label' => 'Début le : ',
                'html5' => true,
                'widget' => 'single_text'
            ])
            ->add('datecloture', type: DateType::class, options: [
                'required' => false,
                'label' => "Fin d'inscription le : ",
                'html5' => true,
                'widget' => 'single_text'
            ])
            ->add('Rechercher', type: SubmitType::class, options: [
                'attr' => [
                    'class' => 'button is-info'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
