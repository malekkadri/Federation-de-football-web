<?php

namespace App\Form;

use App\Entity\Stade;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class StadeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lieu')
            ->add('noms')
            ->add('etat',ChoiceType::class, [

        "choices" => [

            "complet" => "complet",

            "en travaux" =>  "en travaux",

            "Olympique" => "Olympique",
        ]
    ])
            ->add('nbrP')
            ->add('photo',FileType::class, array('data_class' => null), [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
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
            'data_class' => Stade::class,
        ]);
    }

}
