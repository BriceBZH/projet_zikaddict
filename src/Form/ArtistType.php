<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Country;
use App\Entity\Media;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtistType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('birthDate')
            ->add('deathDate')
            ->add('dead')
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_label' => 'name',
            ])
            ->add('media', EntityType::class, [
                'class' => Media::class,
                'choice_label' => 'alt',
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
