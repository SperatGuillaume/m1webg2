<?php


namespace App\Controller\Site;


use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {


    /**
     * @Route("/", name="home.index")
     */

    public function index(ArtworkRepository $artworkRepository):Response{

        $artworks = $artworkRepository->findBy(
            array(),
            array(),
            4
        );

        return $this->render('public/index.html.twig',[
            'artworks' => $artworks
        ]);
    }
}