<?php

namespace App\Form;

use App\Entity\CandidateMetadata;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetadataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'placeholder' => 'Site',
                'attr' => ['class' => 'form-select'],
                'label' => false,
                'choices' => [
                    'Linkedin' => CandidateMetadata::METADATA_LINKEDIN,
                    'Github' => CandidateMetadata::METADATA_GITHUB,
                    'Portfolio' => CandidateMetadata::METADATA_PORTFOLIO,
                ],
                'by_reference' => false,
            ])
            ->add('metadata', UrlType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'http://...',
                ],
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CandidateMetadata::class,
        ]);
    }
}
