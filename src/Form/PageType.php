<?php

namespace App\Form;

use App\Entity\Page;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titreOnglet')
            ->add('titrePage')
            ->add('file', FileType::class,[ 
                'mapped' => false,
                'label' => 'Affiche',
                'required'=> false,
            ])
            ->add('texte')
            ->add('actif')
            ->add('ordre')
            // ->add('submit', SubmitType::class, ['label'=> 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Page::class,
        ]);
    }
}
