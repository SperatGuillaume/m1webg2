<?php

namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/artwork")
 */
class ArtworkController extends AbstractController{

    /**
     * @Route("/", name="artwork.index")
     */
    public function index():Response{
        return $this->render('admin/artwork/index.html.twig');
    }
}