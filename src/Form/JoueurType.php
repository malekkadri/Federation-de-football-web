<?php

namespace App\Form;

use App\Entity\Joueur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class JoueurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('age')
            ->add('nbm')
            ->add('nba')
            ->add('numt')
            ->add('poste',ChoiceType::class, [

                "choices" => [
        
                    "GOALKEEPERS" => "GOALKEEPERS",
        
                    "DEFENDERS" =>  "DEFENDERS",
        
                    "MILIEU" => "MILIEU",

                    "ATTACK" => "ATTACK",
                ]
            ])
            ->add('nationalite')
            ->add('photo',FileType::class, array('data_class' => null), [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('club')
            ->add('Save', SubmitType::class, [

                'label' => 'Envoyer',

                'attr' => [

                    'class' => 'btn-primary pr-5 pl-5 d-table mx-auto text-white'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Joueur::class,
        ]);
    }
}
