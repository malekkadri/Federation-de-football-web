<?php

namespace App\Form;

use App\Entity\Sponsor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SponsorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomS')
            ->add('logoS',FileType::class, array('data_class' => null), [
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
            'data_class' => Sponsor::class,
        ]);
    }
}
