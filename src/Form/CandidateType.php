<?php

namespace App\Form;

use App\Entity\Candidate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('location', TextType::class)
            ->add('phone', TextType::class)
            ->add('resume')
            ->add('introduction')
            ->add('jobTitle')
            ->add('experience')
            ->add('picture')
            ->add('visible')
            // ->add('user')
            // ->add('skills')
            // ->add('favoriteOffers')
            // ->add('favorite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
        ]);
    }
}
