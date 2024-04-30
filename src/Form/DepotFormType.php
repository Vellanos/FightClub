<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Regex;

class DepotFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('wallet', null, [
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'number', 'message' => 'Le montant doit être un nombre.']),
                    new GreaterThan(['value' => 0, 'message' => 'Le montant doit être supérieur à zéro.']),
                    new Regex([
                        'pattern' => '/^\d+([\.,]\d{1,2})?$/',
                        'message' => 'Le montant doit avoir au maximum deux chiffres après le séparateur décimal.'
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
