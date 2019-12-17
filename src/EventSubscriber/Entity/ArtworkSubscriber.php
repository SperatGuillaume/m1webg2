<?php

namespace App\EventSubscriber\Entity;

use App\Entity\Artwork;
use App\Service\FileService;
use App\Service\StringService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArtworkSubscriber implements EventSubscriber
{

    private $stringService;
    private $fileService;

    public function __construct(StringService $stringService, FileService $fileService)
    {
        $this->stringService = $stringService;
        $this->fileService = $fileService;
    }


    public function prePersist(LifecycleEventArgs $args):void
    {
        // par défaut, les souscripteurs écoutent toutes les entités
        $entity = $args->getObject();

        if(!$entity instanceof Artwork){
            return;
        } else {
            // création du slug
            $name = $entity->getName();
            $slug = $this->stringService->getSlug($name);
            $entity->setSlug($slug);



            // transfert d'image
            if($entity->getImage() instanceof UploadedFile){

                $this->fileService->upload($entity->getImage(), 'img/artwork');

                // mise à jour de la propriété image
                $entity->setImage( $this->fileService->getFileName() );
            }
        }
    }
    public function postLoad(LifecycleEventArgs $args):void
    {
        $entity = $args->getObject();

        if (!$entity instanceof Artwork) {
            return;
        }else {
            $entity->prevImage = $entity->getImage();
        }
    }

    public function preUpdate(LifecycleEventArgs $args):void
    {
        $entity = $args->getObject();
        if (!$entity instanceof Artwork) {
            return;
        }else {

            if($entity->getImage() instanceof UploadedFile){
                $this->fileService->upload($entity->getImage(), 'img/artwork');
                $entity->setImage($this->fileService->getFileName());

                if(file_exists("img/artwork/{$entity->prevImage}")){
                    $this->fileService->remove('img/artwork', $entity->prevImage);
                }
            }else{
                $entity->setImage($entity->prevImage);
            }
        }
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::postLoad,
            Events::preUpdate
        ];
    }

}
