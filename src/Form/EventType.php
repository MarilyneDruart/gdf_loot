<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Item;
use App\Entity\Player;
use App\Entity\Raid;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateTimeType::class, [
                'label' => 'Date de l\'événement',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'html5' => true,
                ]
            )
            ->add('raid', EntityType::class, [
                'class' => Raid::class,
                'label' => 'Raid(s)',
                'choice_label' => 'name',
                'multiple' => true, 
                'expanded' => true,
                'required' => true,
                ]
            )
            ->add('log', TextType::class, [
                'label' => 'URL log',
                ]
            )
            ->add('start', DateTimeType::class, [
                'label' => 'Date de début de l\'événement',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'html5' => true,
                ]
            )
            ->add('end', DateTimeType::class, [
                'label' => 'Date de fin de l\'événement',
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
                'html5' => true,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
