<?php


namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class PayementBetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option)
    {
        $builder
            ->add ('amount',IntegerType::class)
            ->add('Valider', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success btn-block'
                ]
            ]);
    }

}