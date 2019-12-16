<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Entity\Category;
use App\EventSubscriber\Form\ArtworkFormSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Le nom est obligatoire"
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "La description est obligatoire"
                    ])
                ]
            ])
            ->add('categories', EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'minMessage' => "Vous devez sélectionner une catégorie au minimum",
                    ])
                ]
            ])
        ;
        $builder->addEventSubscriber(new ArtworkFormSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
