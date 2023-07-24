<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices' => [
                    Application::STATUS_ACCEPTED => Application::STATUS_ACCEPTED,
                    Application::STATUS_REJECTED => Application::STATUS_REJECTED,
                ],
                'label' => 'Change the status',
                'attr' => [
                    'class' => 'form-select',
                ],
            ])
            ->add('mailMessage', TextareaType::class, [
                'required' => false,
                'label' => 'Your message',
                'attr' => [
                    'placeholder' => 'Dear candidate, ...',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
