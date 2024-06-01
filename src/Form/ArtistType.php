<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Country;
use App\Entity\Media;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('birthDate')
            ->add('deathDate')
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
            ])
            ->add('media', EntityType::class, [
                'class' => Media::class,
                'choice_label' => 'alt',
                'attr' => [
                    'style' => 'display: none;',
                ],
                'label_attr' => [
                    'style' => 'display: none;',
                ],
            ])
            ->add('mediabis', TextType::class, [
                'label' => "Url du média",
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artist::class,
        ]);
    }
}
