<?php

namespace App\Form;

use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'required' => false
            ])
            ->add('nom', TextType::class, [
                'required' => false
            ])
            ->add('username', TextType::class, [
                'label' => 'Pseudo',
                'required' => false,
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                )
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                )
            ])
            ->add('file', FileType::class, [
                'label' => 'Image de profil',
                'required' => false,
                'constraints' => array(
                    new Assert\Image(array(
                        'mimeTypes' => array(
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ),
                        'mimeTypesMessage' => 'Veuillez choisir une image au format PNG, JPG ou JPEG', 
                    )),
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    )),
                )
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Membre::class,
        ]);
    }
}
