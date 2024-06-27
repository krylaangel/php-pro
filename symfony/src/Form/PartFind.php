<?php

namespace App\Form;

use App\CarMaster\Entity\Vehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PartFind extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder->add('vehicles', EntityType::class, [
            'class' => Vehicle::class,
            'label' => 'Search by',
            'choice_label' => 'licensePlate',
            'placeholder' => 'Choose search type',
        ]);
    }
}