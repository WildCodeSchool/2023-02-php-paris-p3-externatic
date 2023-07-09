<?php

namespace App\Form;

use App\Entity\Application;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('status', HiddenType::class, [
            //     'required' => false,
            // ])
            // ->add('createdAt', DateTimeType::class, [
            //     'required' => false,
            // ])
            // ->add('candidate', HiddenType::class, [
            //     'required' => false,
            // ])
            ->add('offer', HiddenType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
