<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('objet', TextType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire'                        
                    ))
                )
            ])
            ->add('prenom', TextType::class, [
                'required' => false
            ])
            ->add('nom', TextType::class, [
                'required' => false                
            ])
            ->add('telephone', TextType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\Regex([
                        'pattern' => '/^((\+)33|0)[1-9](\d{2}){4}$/',
                        'message' => 'Téléphone invalide'
                    ])
                )
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire'
                    )),
                    new Assert\Regex([
                        'pattern' => '/^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}/',
                        'message' => 'Email invalide'
                    ])
                )
            ])
            
            ->add('message', TextareaType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire'
                    ))
                )
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
