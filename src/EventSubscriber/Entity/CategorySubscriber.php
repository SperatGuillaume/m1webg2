<?php

namespace App\EventSubscriber\Entity;

use App\Entity\Category;
use App\Entity\Expo;
use App\Service\FileService;
use App\Service\StringService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Console\Event\ConsoleErrorEvent;

class CategorySubscriber implements EventSubscriber
{

    private $stringService;

    public function __construct(StringService $stringService)
    {
        $this->stringService = $stringService;
    }


    public function prePersist(LifecycleEventArgs $args):void
    {
        // par défaut, les souscripteurs écoutent toutes les entités
        $entity = $args->getObject();

        if(!$entity instanceof Category){
            return;
        } else {

            // création du slug
            $name = $entity->getName();
            $slug = $this->stringService->getSlug($name);
            $entity->setSlug($slug);
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist
        ];
    }

}
