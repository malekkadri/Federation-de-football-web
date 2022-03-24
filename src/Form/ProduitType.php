<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Marques;
use App\Entity\Produit;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaTypeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;




class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder



            ->add('nomP',TextType::class,['attr'=>[
                'placeholder'=>"Nom Produit"
            ]])

            ->add('categorie',EntityType::class,
                ['class'=>Categorie::class,'choice_label'=>'typeC','label'=>'Categorie'])

            ->add('marquep',EntityType::class,
                ['class'=>Marques::class,'choice_label'=>'nomM','label'=>'Marques'])

            ->add('taille',ChoiceType::class
            ,array('choices'=>array(

                'Ajouter taille'=>'vide',
                'S' =>'s',
                'M'=>'m',
                'L'=>'l')))

            ->add('taille2',ChoiceType::class
                ,array('choices'=>array(

                    'Ajouter taille'=>'vide',
                    'S' =>'s',
                    'M'=>'m',
                    'L'=>'l')))

            ->add('couleur',ChoiceType::class,array('choices'=>array(

                'Ajouter Couleur'=>'',
                'Noire' =>'noire',
                'Rouge'=>'rouge',
                'Blanc'=>'blanc')))


            ->add('descr',TextareaType::class,['attr'=>['placeholder'=>'Description de Produit']])

            ->add('qte')

            ->add('img', FileType::class,['mapped'=>false, array('data_class' => null)])
            ->add('img', FileType::class, array('data_class' => null,'required' => false))

            ->add('prix')

        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
