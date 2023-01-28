<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Item;
use App\Entity\Slot;
use App\Entity\Player;
use App\Entity\Raid;
use App\Entity\Role;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id')
            ->add('name', TextType::class, [
            'label' => 'Nom de l\'item',
            ])
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Bis' => 'Bis',
                    'Contested' => 'Contested'],
                'expanded' => true,
                'multiple' => false,
                ])
            ->add('detail', TextType::class, [
                'label' => 'URL',
                ])
            ->add('raid', EntityType::class, [
                'class' => Raid::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => true,
                'required' => true,]
            )
            ->add('slots', EntityType::class, [
                'class' => Slot::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'required' => true,]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
