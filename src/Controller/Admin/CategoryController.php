<?php

namespace App\Controller\Admin;


use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/category")
 */
class CategoryController extends AbstractController{

    /**
     * @Route("/", name="admin.category.index")
     */
    public function index(CategoryRepository $categoryRepository):Response{
        $results = $categoryRepository->findAll();

        return $this->render('admin/category/index.html.twig', [
            'results' => $results
        ]);
    }


    /**
     * @Route("/form", name="admin.category.form")
     * @Route("/form/update/{id}", name="admin.category.form.update")
     */
    public function form(Request $request, EntityManagerInterface $entityManager, int $id = null, CategoryRepository $categoryRepository):Response
    {
        // si l'id est nul, une insertion est exécutée, sinon une modification est exécutée
        $model = $id ? $categoryRepository->find($id) : new Category();
        $type = CategoryType::class;
        $form = $this->createForm($type, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){



            $message = $model->getId() ? "La catégorie a été modifié" : "La catégorie a été ajouté";


            $this->addFlash('notice', $message);

            $model->getId() ? null : $entityManager->persist($model);
            $entityManager->flush();

            // redirection
            return $this->redirectToRoute('admin.category.index');
        }

        return $this->render('admin/category/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/remove/{id}", name="admin.category.remove")
     */
    public function remove(CategoryRepository $categoryRepository, EntityManagerInterface $entityManager, int $id):Response
    {
        // autoriser la route uniquement aux super admin
        /*if(!$this->isGranted('ROLE_SUPER_ADMIN')){
            $this->addFlash('error', "Vous n'êtes pas autorisé à supprimer un produit");
            return $this->redirectToRoute('admin.product.index');
        }*/

        // sélection de l'entité à supprimer
        $model = $categoryRepository->find($id);

        // suppression dans la table
        $entityManager->remove($model);
        $entityManager->flush();

        // message et redirection
        $this->addFlash('notice', "La catégorie a été supprimé");
        return $this->redirectToRoute('admin.category.index');
    }
}