<?php

namespace App\Form;

use App\Entity\CandidateMetadata;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\SecurityBundle\Security;

class MetadataType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'placeholder' => 'Site',
                'attr' => ['class' => 'form-select border-primary mt-2'],
                'label' => false,
                'choices' => [
                    'Linkedin' => CandidateMetadata::METADATA_LINKEDIN,
                    'Github' => CandidateMetadata::METADATA_GITHUB,
                    'Portfolio' => CandidateMetadata::METADATA_PORTFOLIO,
                ],
            ])
            ->add('metadata', UrlType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary mt-2',
                    'placeholder' => 'http://...',
                ],
            ])
            ->add('candidate', HiddenType::class, [
                'empty_data' =>  $this->security->getUser()->getCandidate(),
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
