<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Format;
use App\Entity\User;
use App\Entity\UserAlbumFormat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserAlbumFormatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('user', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
            ])
            ->add('album', EntityType::class, [
                'class' => Album::class,
'choice_label' => 'id',
            ])
            ->add('format', EntityType::class, [
                'class' => Format::class,
'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserAlbumFormat::class,
        ]);
    }
}
