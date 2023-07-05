<?php

namespace App\Form;

use App\Entity\Candidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('location')
            ->add('phone')
            // ->add('resume')
            ->add('resume', DropzoneType::class, [
                'label' => 'Candidate\'s resume',
            ])
            ->add('introduction')
            ->add('jobTitle')
            ->add('experience')
            // ->add('picture')
            ->add('pictureFile', DropzoneType::class, [
                'label' => 'Candidate\'s picture',
            ])
            ->add('visible')
            ->add('user')
            ->add('skills')
            ->add('favoriteOffers')
            ->add('favorite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
