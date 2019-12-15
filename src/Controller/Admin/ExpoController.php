<?php

namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/expo")
 */
class ExpoController extends AbstractController{

    /**
     * @Route("/", name="expo.index")
     */
    public function index():Response{
        return $this->render('admin/expo/index.html.twig');
    }
}