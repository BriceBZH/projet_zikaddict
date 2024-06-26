<?php

namespace App\Form;

use App\Entity\Media;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class MediaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url')
            ->add('alt')
            ->add('urlSource')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Media::class,
        ]);
    }
}
