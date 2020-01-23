<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('titlePreview', TextType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'min' => 30,
                        'max' => 80,
                        'minMessage' => 'Le titre de présentation doit contenir au minimum 30 caractères',
                        'maxMessage' => 'Le titre de présentation doit contenir au maximum 80 caractères',
                    )),
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                ),
            ])

            ->add('textPreview', TextType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'min' => 20,
                        'max' => 150,
                        'minMessage' => 'Le texte de présentation doit contenir au minimum 20 caractères',
                        'maxMessage' => 'Le texte de présentation doit contenir au maximum 150 caractères',
                    )),
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                ),
            ])

            ->add('file', FileType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\Image(array(
                        'mimeTypes' => array(
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ),
                        'mimeTypesMessage' => 'Veuillez choisir une image au format PNG, JPG ou JPEG',
                        'minHeight' => 480,
                        'minWidth' => 1280,
                        'minHeightMessage' => 'La hauteur de l\'image doit être d\'au moins 480 pixels',
                        'minWidthMessage' => 'La largeur de l\'image doit être d\'au moins 1280 pixels'
                    )),
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                ),
            ])

            ->add('titre', TextType::class, [
                'required' => false,
                    'constraints' => array(
                        new Assert\Length(array(
                            'min' => 30,
                            'max' => 80,
                            'minMessage' => 'Le titre de l\'article doit contenir au minimum 30 caractères',
                            'maxMessage' => 'Le titre de l\'article doit contenir au maximum 80 caractères',
                        )),
                        new Assert\NotBlank(array(
                            'message' => 'Ce champ est obligatoire',
                        ))
                    ),
            ])

            ->add('firstParagraph', TextareaType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'min' => 400,
                        'max' => 3000,
                        'minMessage' => 'Le paragraphe doit contenir au minimum 400 caractères',
                        'maxMessage' => 'Le paragraphe doit contenir au maximum 3000 caractères',
                    )),
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                ),       
            ])

            ->add('secondParagraph', TextareaType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'min' => 400,
                        'max' => 3000,
                        'minMessage' => 'Le paragraphe doit contenir au minimum 400 caractères',
                        'maxMessage' => 'Le paragraphe doit contenir au maximum 3000 caractères',
                    )),
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                ), 
            ])
            
            ->add('thirdParagraph', TextareaType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'min' => 400,
                        'max' => 3000,
                        'minMessage' => 'Le paragraphe doit contenir au minimum 400 caractères',
                        'maxMessage' => 'Le paragraphe doit contenir au maximum 3000 caractères',
                    )),
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                ),
            ])

            ->add('fileun', FileType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\Image(array(
                        'mimeTypes' => array(
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ),
                        'mimeTypesMessage' => 'Veuillez choisir une image au format PNG, JPG ou JPEG',
                        'minHeight' => 300,
                        'minWidth' => 300,
                        'minHeightMessage' => 'Les dimensions de l\'image doivent être supérieures à 300 x 300 pixels',
                        'minWidthMessage' =>  'Les dimensions de l\'image doivent être supérieures à 300 x 300 pixels'
                    )),
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                ),
            ])

            ->add('fourthParagraph', TextareaType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'min' => 400,
                        'max' => 3000,
                        'minMessage' => 'Le paragraphe doit contenir au minimum 400 caractères',
                        'maxMessage' => 'Le paragraphe doit contenir au maximum 3000 caractères',
                    )),
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                ),      
            ])

            ->add('fifthParagraph', TextareaType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\Length(array(
                        'min' => 400,
                        'max' => 3000,
                        'minMessage' => 'Le paragraphe doit contenir au minimum 400 caractères',
                        'maxMessage' => 'Le paragraphe doit contenir au maximum 3000 caractères',
                    )),
                    new Assert\NotBlank(array(
                    'message' => 'Ce champ est obligatoire',
                    ))
                 ),  
            ])

            ->add('filedeux', FileType::class , [
                'required' => false,
                'constraints' => array(
                    new Assert\Image(array(
                        'mimeTypes' => array(
                            'image/png',
                            'image/jpeg',
                            'image/jpg',
                        ),
                        'mimeTypesMessage' => 'Veuillez choisir une image au format PNG, JPG ou JPEG',
                        'minHeight' => 300,
                        'minWidth' => 300,
                        'minHeightMessage' => 'Les dimensions de l\'image doivent être supérieures à 300 x 300 pixels',
                        'minWidthMessage' =>  'Les dimensions de l\'image doivent être supérieures à 300 x 300 pixels'
                    )),
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                ),
            ])

            ->add('categorie', ChoiceType::class, [
                'choices'  => [
                    'Multiplateforme' => 'multiplateforme',
                    'PC' => 'pc',
                    'PS4' => 'ps4',
                    'Xbox' => 'xbox',
                    'Nintendo' => 'nintendo',
                ],
                'invalid_message' => 'Catégorie invalide.'
            ])


            ->add('submit', SubmitType::class, array(
                'label' => 'Publier l\'article'
            ))

            ->add('video', TextareaType::class, [
                'required' => false,
                'constraints' => array(
                    new Assert\NotBlank(array(
                        'message' => 'Ce champ est obligatoire',
                    ))
                ),       
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
