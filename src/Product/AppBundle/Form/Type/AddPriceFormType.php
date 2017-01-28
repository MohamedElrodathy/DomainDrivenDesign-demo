<?php

declare(strict_types=1);

namespace Product\AppBundle\Form\Type;

use Product\AppBundle\Form\Model\AddPriceFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AddPriceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('productId')
            ->add('sellerId')
            ->add('availableFrom')
            ->add('availableUntil')
            ->add('amount', MoneyType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => AddPriceFormModel::class,
        ]);
    }
}
