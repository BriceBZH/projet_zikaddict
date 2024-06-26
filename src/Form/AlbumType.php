<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Media;
use App\Entity\Artist;
use App\Entity\Format;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => "Titre de l'album"
            ])
            ->add('year', null, [
                'label' => "Année de sortie"
            ])
            ->add('artists', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'label' => "Artistes"
            ])
            ->add('formats', EntityType::class, [
                'class' => Format::class,
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => false,
            ]);
            if ($options['is_edit']) { //if edit
                $builder->add('media', EntityType::class, [
                    'class' => Media::class,
                    'choice_label' => 'alt',             
                ])
                ->add('mediaUrl', TextType::class, [
                    'label' => "Url du média",
                    'mapped' => false,
                    'required' => false,
                ])
                ->add('mediaUpload', FileType::class, [
                    'label' => "Uploader un média",
                    'mapped' => false,
                    'required' => false,
                ]);
            } else { //if add
                $builder->add('media', EntityType::class, [
                    'class' => Media::class,
                    'choice_label' => 'alt',
                    'attr' => [
                        'style' => 'display: none;',
                    ],
                    'label_attr' => [
                        'style' => 'display: none;',
                    ],
                ])
                ->add('mediaUrl', TextType::class, [
                    'label' => "Url du média",
                    'mapped' => false, 
                    'required' => false,               
                ])
                ->add('mediaUpload', FileType::class, [
                    'label' => "Uploader un média",
                    'mapped' => false,
                    'required' => false,
                ]);
            }
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
            'is_edit' => false,
        ]);
    }
}
