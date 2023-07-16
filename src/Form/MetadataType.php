<?php

namespace App\Form;

use App\Entity\CandidateMetadata;
use App\Form\DataTransformer\IssueToCandidateTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bundle\SecurityBundle\Security;

class MetadataType extends AbstractType
{
    public function __construct(
        private Security $security,
        private IssueToCandidateTransformer $transformer
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('linkedin', UrlType::class, [
                'label' => 'Linkedin',
                'attr' => [
                    'class' => 'form-control border-primary mt-2',
                    'placeholder' => 'https://www.linkedin.com/in/yourname',
                ],
                'empty_data' => '',
                'required' => false,
            ])
            ->add('github', UrlType::class, [
                'attr' => [
                    'class' => 'form-control border-primary mt-2',
                    'placeholder' => 'https://github.com/yourpseudo',
                ],
                'label' => 'Github',
                'label_attr' => ['class' => 'mt-2'],
                'empty_data' => '',
                'required' => false,
            ])
            ->add('portefolio', UrlType::class, [

                'attr' => [
                    'class' => 'form-control border-primary mt-2',
                    'placeholder' => 'http://...',
                ],
                'label' => 'Portefolio',
                'label_attr' => ['class' => 'mt-2'],
                'empty_data' => '',
                'required' => false,
            ])
            ->add('other', UrlType::class, [
                'label' => 'Other',
                'attr' => [
                    'class' => 'form-control border-primary mt-2',
                    'placeholder' => 'http://...',
                ],
                'label_attr' => ['class' => 'mt-2'],
                'empty_data' => '',
                'required' => false,
            ])
            ->add('candidate', HiddenType::class, [
                'empty_data' =>  $this->security->getUser()->getCandidate(),
                'by_reference' => false,
            ])
        ;
        $builder->get('candidate')
        ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CandidateMetadata::class,
        ]);
    }
}
