<?php

namespace App\Form;

use App\Entity\Marque;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert; 
use Symfony\Component\Validator\Constraints\NotBlank;


class MarqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('id', TextType::class,[
            "attr"=>[
            ], 
            "label"=>"id", 
            "label_attr"=>[
                'class'=>'form-label mt-4'
            ], 
            'constraints'=>[
            ]
            
        ])
            ->add('nom', TextType::class,[
                "attr"=>[
                    'class'=>'form-controle', 
                    'min-length'=>'2',
                    'max-length'=>'50'
                ], 
                "label"=>"Nom", 
                "label_attr"=>[
                    'class'=>'form-label mt-4'
                ], 
                'constraints'=>[
                    new Assert\Length(['min'=>2, 'max'=>50]),
                    new Assert\NotBlank()
                ]
                
            ])
            ->add('dateCreation', DateType::class,[
                "attr"=>[
                    'class'=>'form-controle', 
                ], 
                "label"=>"Date", 
                "label_attr"=>[
                    'class'=>'form-label mt-4'
                ], 
                'constraints'=>[
                ]
                
            ])
            ->add('logo', FileType::class, [
                'label' => 'Image (jpg, png)',

                // unmapped means that this field is not associated to any entity property
                'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using attributes
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image',
                    ])
                ],
            ])
            
            ->add('Submit', SubmitType::class, [
                'attr'=>[
                    'class' =>"btn btn-primary"
                ],
                'label'=>'ajouter une marque'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Marque::class,
        ]);
    }
}
