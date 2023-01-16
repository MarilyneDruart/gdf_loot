<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Participation;
use App\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isBench')
            ->add('player',
            EntityType::class, [
                'class' => Player::class,
                'label' => 'Joueurs',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                ]
            )
            // ->add('event', EntityType::class, [
            //     'class' => Event::class,
            //     'label' => 'Event',
            //     'data' => $options['event'],
            //     'choice_label' => 'date',
            //     'multiple' => false,
            //     'expanded' => false,
            //     'required' => true
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participation::class,
            'event' => null
        ]);
    }
}