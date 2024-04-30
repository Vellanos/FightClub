<?php

namespace App\Form;

use App\Entity\Bet;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundleSecurity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;

class BetFormType extends AbstractType
{
    private $security;

    public function __construct(SecurityBundleSecurity $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser(); 
        $walletUser = $user ? $user->getWallet() : null;

        $builder
            ->add('bet_value', null, [
                'constraints' => [
                    new NotBlank(),
                    new Type(['type' => 'number', 'message' => 'Le montant doit être un nombre.']),
                    new GreaterThan(['value' => 0, 'message' => 'Le montant doit être supérieur à zéro.']),
                    new LessThanOrEqual(['value' => $walletUser, 'message' => 'Le montant ne peut pas dépasser le montant de votre wallet.']) ,
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
            'data_class' => Bet::class,
        ]);
    }
}
