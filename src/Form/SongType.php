<?php

namespace App\Form;

use App\Entity\Genre;
use App\Entity\Song;
use App\Entity\Artist;
use App\Entity\Album;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SongType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => "Titre de la chanson"
            ])
            ->add('description')
            ->add('duration', null, [
                'label' => "Durée de la chanson"
            ])
            ->add('artists', EntityType::class, [
                'class' => Artist::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'label' => "Artistes",
            ])
            ->add('albums', EntityType::class, [
                'class' => Album::class,
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => false,
            ])
            ->add('genre', EntityType::class, [
                'class' => Genre::class,
                'choice_label' => 'libelle',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Song::class,
        ]);
    }
}
