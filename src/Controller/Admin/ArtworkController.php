<?php

namespace App\Controller\Admin;


use App\Entity\Artwork;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use App\Service\FileService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/artwork")
 */
class ArtworkController extends AbstractController{

    /**
     * @Route("/", name="admin.artwork.index")
     */
    public function index(ArtworkRepository $artworkRepository):Response{
        $results = $artworkRepository->findAll();

        return $this->render('admin/artwork/index.html.twig', [
            'results' => $results
        ]);
    }


    /**
     * @Route("/form", name="admin.artwork.form")
     * @Route("/form/update/{id}", name="admin.artwork.form.update")
     */
    public function form(Request $request, EntityManagerInterface $entityManager, int $id = null, ArtworkRepository $artworkRepository):Response
    {
        // si l'id est nul, une insertion est exécutée, sinon une modification est exécutée
        $model = $id ? $artworkRepository->find($id) : new Artwork();
        $type = ArtworkType::class;
        $form = $this->createForm($type, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //dd($form->getData());

            // message de confirmation
            $message = $model->getId() ? "L'oeuvre a été modifié" : "L'oeuvre a été ajouté";

            // message stocké en session
            $this->addFlash('notice', $message);

            /*
             * insertion dans la base de données
             *  - persist: méthode déclenchée uniquement lors d'une insertion
             *  - lors d'une mise à jour, aucune méthode n'est requise
             *  - remove: méthode déclenchée uniquement lors d'une suppression
             *  - flush: exécution des requêtes SQL
             */
            $model->getId() ? null : $entityManager->persist($model);
            $entityManager->flush();

            // redirection
            return $this->redirectToRoute('admin.artwork.index');
        }

        return $this->render('admin/artwork/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/remove/{id}", name="admin.artwork.remove")
     */
    public function remove(ArtworkRepository $artworkRepository, EntityManagerInterface $entityManager, int $id, FileService $fileService):Response
    {
        // autoriser la route uniquement aux super admin
        /*if(!$this->isGranted('ROLE_SUPER_ADMIN')){
            $this->addFlash('error', "Vous n'êtes pas autorisé à supprimer un produit");
            return $this->redirectToRoute('admin.product.index');
        }*/

        // sélection de l'entité à supprimer
        $model = $artworkRepository->find($id);

        // suppression dans la table
        $entityManager->remove($model);
        $entityManager->flush();

        // suppression de l'image
        if(file_exists("img/artwork/{$model->getImage()}")){
            $fileService->remove('img/artwork', $model->getImage());
        }

        // message et redirection
        $this->addFlash('notice', "L'oeuvre a été supprimé");
        return $this->redirectToRoute('admin.artwork.index');
    }
}