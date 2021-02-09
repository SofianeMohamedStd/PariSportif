<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserRestInformation extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('street', TextType::class)
            ->add('city', TextType::class)
            ->add('codePostal', TextType::class)
            ->add('phone', TextType::class)
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Password',
            ])
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success btn-block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
