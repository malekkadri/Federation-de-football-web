<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet')





            ->add('status', ChoiceType::class, [

                "choices" => [

                    "Comptabilité et factures" => "Comptabilité et factures",
                    "Rejoindre ou quitter TurboDevs" => "Rejoindre ou quitter TurboDevs",
                    "Sevices et personel de TurboDevs" => "Sevices et personel de TurboDevs",
                    "Autre" => "Autre"
                ],

                "label" => "status"
            ])
            ->add('descR')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
