<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Request\HistoryRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class HistoryRequestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('symbol')
            ->add('startDate', DateTimeType::class, [
                'input' => 'datetime_immutable',
            ])
            ->add('endDate', DateTimeType::class, [
                'input' => 'datetime_immutable',
            ])
            ->add('email', EmailType::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', HistoryRequest::class);
    }
}
