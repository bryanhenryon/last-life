<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class MembreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom :',
            ])

            ->add('nom', TextType::class, [
                'label' => 'Nom :',
            ])
            ->add('username', TextType::class, [
                'label' => 'Pseudo :',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire'
                    )),
                )

            ])
            ->add('email', EmailType::class, [
                'label' => 'Email :',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire'
                    )),
                )
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire'
                    ))
                )
            ])

            ->add('confirm_password', PasswordType::class, [
                'label' => 'Confirmation du mot de passe',
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire'
                    ))
                )
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
            'admin' => false,
            'password' => true,
            'attr' => ['novalidate' => 'novalidate']
        ]);
    }
}
