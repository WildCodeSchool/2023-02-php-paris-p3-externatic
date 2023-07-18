<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Name of the company',
                ],
            ])
            ->add('size', ChoiceType::class, [
                'choices' => Company::COMPANY_SIZE,
                'choice_label' => function ($choice, string $key, mixed $value) {
                    return $choice;
                },
                'placeholder' => 'Size',
                'attr' => ['class' => 'form-select border-primary'],
                'label' => false,
            ])
            ->add('sector', ChoiceType::class, [
                'choices' => Company::COMPANY_SECTOR,
                'placeholder' => 'Sector',
                'attr' => ['class' => 'form-select border-primary'],
                'label' => false,
            ])
            ->add('presentation', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Presentation',
                ],
            ])
            ->add('location', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-primary',
                    'placeholder' => 'Location',
                ],
            ])
            ->add('logoFile', DropzoneType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Browse your logo here',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
