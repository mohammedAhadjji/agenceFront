<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class, [
                'label' => 'fullname *',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email Address (Cannot be changed)',
                'required' => true,
                'disabled' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('phoneNember', TextType::class, [
                'label' => 'Phone *',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Address *',
                'required' => true,
                'attr' => ['class' => 'form-control', 'rows' => 4],
            ])
            ->add('ville', TextType::class, [
                'label' => 'ville *',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            
            ->add('pays', TextType::class, [
                'label' => 'pays *',
                'required' => true,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
                'required' => false,
                'mapped' => false,
                'attr' => ['class' => 'form-control'],
            ])
            ->add('retypedPlainPassword', PasswordType::class, [
                'label' => 'Retype Password',
                'required' => false,
                'mapped' => false,
                'attr' => ['class' => 'form-control'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
