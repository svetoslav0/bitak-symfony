<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Category;
use App\Entity\City;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
                'label_attr' => [
                    'class' => 'col-sm-2 col-form-label'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose category . . .',
                'multiple' => false,
                'label_attr' => [
                    'class' => 'col-sm-2 col-form-label'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label_attr' => [
                    'class' => 'col-sm-2 col-form-label'
                ]
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose City . . .',
                'multiple' => false,
                'label_attr' => [
                    'class' => 'col-sm-2 col-form-label'
                ]
            ])
            ->add('contactEmail', TextType::class, [
                'label_attr' => [
                    'class' => 'col-sm-2 col-form-label'
                ]
            ])
            ->add('contactName', TextType::class, [
                'label_attr' => [
                    'class' => 'col-sm-2 col-form-label'
                ]
            ])
            ->add('contactPhone', TextType::class, [
                'label_attr' => [
                    'class' => 'col-sm-2 col-form-label'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class
        ]);
    }
}
