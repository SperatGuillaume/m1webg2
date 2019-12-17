<?php

namespace App\Controller\Admin;


use App\Entity\Expo;
use App\Form\ExpoType;
use App\Repository\ExpoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/expo")
 */
class ExpoController extends AbstractController{

    /**
     * @Route("/", name="admin.expo.index")
     */
    public function index(ExpoRepository $expoRepository):Response{
        $results = $expoRepository->findAll();

        //dd($results);
        return $this->render('admin/expo/index.html.twig', [
            'results' => $results
        ]);
    }


    /**
     * @Route("/form", name="admin.expo.form")
     * @Route("/form/update/{id}", name="admin.expo.form.update")
     */
    public function form(Request $request, EntityManagerInterface $entityManager, int $id = null, ExpoRepository $expoRepository):Response
    {
        // si l'id est nul, une insertion est exécutée, sinon une modification est exécutée
        $model = $id ? $expoRepository->find($id) : new Expo();
        $type = ExpoType::class;
        $form = $this->createForm($type, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //dd($form->getData());

            // message de confirmation
            $message = $model->getId() ? "L'exposition a été modifié" : "L'exposition a été ajouté";

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
            return $this->redirectToRoute('admin.expo.index');
        }

        return $this->render('admin/expo/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/remove/{id}", name="admin.expo.remove")
     */
    public function remove(ExpoRepository $expoRepository, EntityManagerInterface $entityManager, int $id):Response
    {
        // autoriser la route uniquement aux super admin
        /*if(!$this->isGranted('ROLE_SUPER_ADMIN')){
            $this->addFlash('error', "Vous n'êtes pas autorisé à supprimer un produit");
            return $this->redirectToRoute('admin.product.index');
        }*/

        // sélection de l'entité à supprimer
        $model = $expoRepository->find($id);

        // suppression dans la table
        $entityManager->remove($model);
        $entityManager->flush();


        // message et redirection
        $this->addFlash('notice', "L'exposition a été supprimé");
        return $this->redirectToRoute('admin.expo.index');
    }
}