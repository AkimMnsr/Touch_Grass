<?php

namespace App\Form;

use App\Entity\Lieux;
use App\Entity\Sorties;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;

class AddSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('datedebut', DateTimeType::class,
                [
                    'html5' => true,
                    'widget' => 'single_text'
                ])
            ->add('datecloture', DateType::class,
                [
                    'html5' => true,
                    'widget' => 'single_text'
                ])
            ->add('nbinscriptionsmax')
            ->add('duree')
            ->add('descriptioninfos', TextareaType::class)
            ->add('lieux_no_lieu', EntityType::class,
                [
                    'class' => Lieux::class,
                    'choice_label' => 'nom_lieu',
                    'choice_value' => function(?Lieux $lieux) {
                        return $lieux ? $lieux:"";
                    }
                ])


            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
            ->add('publish', SubmitType::class, ['label' => 'Publier la sortie'])
            ->add('remove', SubmitType::class, ['label' => 'Supprimer la sortie'])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sorties::class,
        ]);
    }


}
