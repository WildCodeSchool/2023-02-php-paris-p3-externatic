<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchApplicationFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('searchTitleApplication', SearchType::class, [
                'required' => false,
                'label' => 'Find an application',
            ])

            ->add('statusApplication', ChoiceType::class, [
                'choices' => Application::APPLICATION_STATUS,
                'required' => false,
                'label' => 'Application status',
                'expanded' => true,
                'multiple' => true,
                'attr' => [
                    'class' => 'dropdown-item form-check'
                ],
            ]);
    }
}
