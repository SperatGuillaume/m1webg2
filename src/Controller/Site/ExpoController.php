<?php

namespace App\Controller\Site;

use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use App\Repository\ExpoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/expositions")
 */

class ExpoController extends AbstractController{
    /**
     * @Route("/", name="site.expo.index", methods={"GET"})
     * @Route("/page/{page}", name="site.expo.page", methods={"GET"})
     */
    public function index(ExpoRepository $expoRepository, $page = 1): Response
    {
        /*
         * fonctionnement doctrine
         *  -deux branches
         *      -gérr les entités(UPDATE, INSERT, DELETE) : EntityManagerInterface
         *      -classe de dépot - Repository  - SELECT
         */


        $nb_expos = $this->getParameter('nb_expos');
        $nb_page = count($expoRepository->getExpoStillAvailable()->getResult()) / $nb_expos;
        /*
        $artworks = $expoRepository->findBy(
            array(),
            array(),
            $nb_expos,
            ($page-1) * $nb_expos
        );
        */
        $expos = $expoRepository->getExpoStillAvailableWithLimit($nb_expos,($page-1) * $nb_expos);
        dd($expos->getResult());

        return $this->render('public/artwork/index.html.twig', [
            'expos' => $expos->getResult(),
            'current_page' => $page,
            'nb_page' =>ceil($nb_page)
        ]);
    }

    /**
     * @Route("/{slug}", name="site.expo.show", methods={"GET"})
     */
    public function show(ExpoRepository $expoRepository, $slug): Response
    {
        $expo = $expoRepository->findOneBy([
            'slug' => $slug
        ]);
        return $this->render('public/expo/show.html.twig', [
            'expo' => $expo,
        ]);
    }

}