<?php

namespace App\Form;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Badge;
use App\Form\BadgeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username')
            ->add('mdp')
            ->add('nbp')
            ->add('email')

            ->add('role', ChoiceType::class, [

                "choices" => [


                    "Client" => "Client",
                    "Administrateur" => "Administrateur"
        ],


                "label" => "role"
            ])

            ->add('img',FileType::class, array('data_class' => null,'required' => false))

            ->add('badge',EntityType::class,
                ['class'=>Badge::class,'choice_label'=>'nomB','label'=>'Badge'])

            ->add('add',SubmitType::class)
      ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
