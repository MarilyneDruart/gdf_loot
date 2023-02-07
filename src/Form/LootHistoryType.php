<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\LootHistory;
use App\Entity\Player;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LootHistoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('player',
            EntityType::class, [
                'class' => Player::class,
                'label' => 'Joueurs',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                ])
            ->add('item',
            EntityType::class, [
                'class' => Item::class,
                'label' => 'Item',
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'required' => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LootHistory::class,
        ]);
    }
}
