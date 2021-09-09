<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  /* par défault les types du form sont en text */
            /* on peut préciser ici aussi comment notre form sera */
            ->add('name', TextType::class, [
                "required" => true,
                "label" => 'Nom',
                "attr" => [
                    "class" => "classNom",
                ]
            ])
            ->add('password', PasswordType::class)
            ->add('firstname')
            ->add('sanitaryPass')
            /* on rajoute un champs, non mapped avec la bdd */
            ->add('mobile', TelType::class, [
                'mapped' => false,
                'required' => true,
                ])
            ->add('submit', SubmitType::class)
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
