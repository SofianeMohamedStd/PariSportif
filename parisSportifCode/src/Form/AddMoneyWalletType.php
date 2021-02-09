<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AddMoneyWalletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add('credit', IntegerType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(
                        [
                            'message' => 'Please enter an amount.'
                        ]
                    )
                ]
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
        ]);
    }
}
