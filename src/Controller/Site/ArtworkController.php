<?php

namespace App\Controller\Site;

use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/oeuvres")
 */

class ArtworkController extends AbstractController{
    /**
     * @Route("/", name="site.artwork.index", methods={"GET"})
     * @Route("/page/{page}", name="site.artwork.page", methods={"GET"})
     */
    public function index(ArtworkRepository $artworkRepository, $page = 1): Response
    {
        /*
         * fonctionnement doctrine
         *  -deux branches
         *      -gérr les entités(UPDATE, INSERT, DELETE) : EntityManagerInterface
         *      -classe de dépot - Repository  - SELECT
         */

        $nb_artworks = $this->getParameter('nb_artworks');
        $nb_page = count($artworkRepository->findAll()) / $nb_artworks;

        $artworks = $artworkRepository->findBy(
            array(),
            array(),
            $nb_artworks,
            ($page-1) * $nb_artworks
        );


        return $this->render('public/artwork/index.html.twig', [
            'artworks' => $artworks,
            'current_page' => $page,
            'nb_page' =>ceil($nb_page)
        ]);
    }

    /**
     * @Route("/categorie/{category}", name="site.artwork.category.index", methods={"GET"})
     * @Route("/categorie/{category}/page/{page}", name="site.artwork.category.page", methods={"GET"})
     */
    public function searchByCategory(ArtworkRepository $artworkRepository, CategoryRepository $categoryRepository, $category, $page = 1): Response
    {

        $category_model = $categoryRepository->findBy(['slug' => $category]);
        $nb_artworks = $this->getParameter('nb_artworks');
        $nb_page = count($artworkRepository->getArtworkByCategoryId($category_model[0]->getId())->getResult()) / $nb_artworks;



        /*
        $artworks = $artworkRepository->findBy(
            array(['categories' => $category_model[0]->getId()]),
            array(),
            $nb_artworks,
            ($page-1) * $nb_artworks
        );
        */
        $artworks = $artworkRepository->getArtworkByCategoryIdWithLimit($category_model[0]->getId(), $nb_artworks,($page-1) * $nb_artworks);
        //dd($artworks->getResult());

        return $this->render('public/artwork/category.html.twig', [
            'artworks' => $artworks->getResult(),
            'category' => $category,
            'current_page' => $page,
            'nb_page' =>ceil($nb_page)
        ]);

    }

    /**
     * @Route("/{slug}", name="site.artwork.show", methods={"GET"})
     */
    public function show(ArtworkRepository $artworkRepository, $slug): Response
    {
        $artwork = $artworkRepository->findOneBy([
            'slug' => $slug
        ]);
        return $this->render('public/artwork/show.html.twig', [
            'artwork' => $artwork,
        ]);
    }

}