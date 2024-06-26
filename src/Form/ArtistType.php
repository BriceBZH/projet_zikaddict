<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Country;
use App\Entity\Media;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => "Nom de l'artiste"
            ])
            ->add('description')
            ->add('birthDate', null, [
                'label' => 'Date de naissance'
            ])
            ->add('deathDate', null, [
                'label' => 'Date de mort'
            ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => "Pays d'origine"
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
            'data_class' => Artist::class,
            'is_edit' => false,
        ]);
    }
}
