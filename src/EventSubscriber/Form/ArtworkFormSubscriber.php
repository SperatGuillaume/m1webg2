<?php

namespace App\EventSubscriber\Form;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotBlank;

class ArtworkFormSubscriber implements EventSubscriberInterface
{
    public function postSetData(FormEvent $event):void
    {
        /*
         * getData : accès à la saisie du formulaire
         * getForm : accès au builder du formulaire
         * $form->getData() : entité
         */
        $model = $event->getData();
        $form = $event->getForm();
        $entity = $form->getData();

        // modifier les contraintes du champ fichier
        // si l'entité est mise à jour, pas de contraintes
        $constraints = $entity->getId() ? [] : [
            new NotBlank([
                'message' => "L'image est obligatoire"
            ]),
            new Image([
                'mimeTypesMessage' => "Vous devez sélectionner une image",
                'mimeTypes' => [ 'image/jpeg', 'image/png', 'image/gif', 'image/svg+xml', 'image/webp' ]
            ])
        ];

        $form->add('image', FileType::class, [
            'data_class' => null, // éviter une erreur lors de la modification d'une entité
            'constraints' => $constraints
        ]);

        //dd($model, $form, $entity);
    }

    public static function getSubscribedEvents():array
    {
        /*
         * PRE_SET_DATA : avant que le formulaire ait accès aux données du modèle
         * POST_SET_DATA : après que le formulaire ait accès aux données du modèle
         */
        return [
            FormEvents::POST_SET_DATA => 'postSetData'
        ];
    }
}
