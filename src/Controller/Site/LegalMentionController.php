<?php

namespace App\Controller\Site;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalMentionController extends AbstractController{


    /**
     * @Route("/mentions-legales", name="site.mentions.legales.index")
     */
    public function index():Response{
        return $this->render('public/legal/index.html.twig');
    }

}