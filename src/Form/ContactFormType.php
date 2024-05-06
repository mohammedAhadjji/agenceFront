<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Full Name']
        ])
        ->add('phone', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Phone Number']
        ])
        ->add('email', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Email Address']
        ])
        ->add('message', TextareaType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Message', 'style' => 'height:195px;']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
