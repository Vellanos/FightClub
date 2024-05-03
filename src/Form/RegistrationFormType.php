<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Type;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', null, [
                'constraints' => [
                    new Length(['max' => 100]),
                ],
            ])
            ->add('firstname', null, [
                'constraints' => [
                    new Length(['max' => 100]),
                ],
            ])
            ->add('pseudo', null, [
                'constraints' => [
                    new Length(['max' => 30]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9_]+$/',
                        'message' => 'Le pseudo ne doit contenir que des lettres, des chiffres ou des underscores.'
                    ]),
                ],
            ])
            ->add('wallet', NumberType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'numeric', 'message' => 'Le montant doit être un nombre.']),
                    new GreaterThan(['value' => 0, 'message' => 'Le montant doit être supérieur à zéro.']),
                    new Regex([
                        'pattern' => '/^\d+([\.,]\d{1,2})?$/',
                        'message' => 'Le montant doit avoir au maximum deux chiffres après le séparateur décimal.'
                    ]),
                ],
            ])
            ->add('email', null, [
                'constraints' => [
                    new Email(['mode' => 'strict']),
                    new Length(['max' => 320]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
