<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('lieux_no_lieu', options: [
                'required'=>false,
                'label' => 'Site : '
            ])
            ->add('nom', options: [
                'required'=>false,
                'label' => 'Le nom de la sortie contient : ',
            ])
            ->add('datedebut', type: DateType::class, options: [
                'required'=>false,
                'label' => 'Début le : ',
                'html5' => true,
                'widget' => 'single_text'
            ])
            ->add('datecloture', type: DateType::class, options: [
                'required'=>false,
                'label' => 'Termine le : ',
                'html5' => true,
                'widget' => 'single_text'
            ])
            /*->add('orga',type:CheckboxType::class,options: [
                'label'=>"Sortie dont je suis l'organisateur/trice"
            ])
            ->add('inscrit',type:CheckboxType::class,options: [
                'label'=>'Sortie auxquelles je suis inscrit/e'
            ])
            ->add('noInscrit',type:CheckboxType::class,options: [
                'label'=>'Sortie auxquelles je ne suis pas inscrit/e'
            ])
            ->add('passe',type:CheckboxType::class,options:[
                'label'=>'Sortie passée'
            ])*/
            ->add('Valider', type: SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
