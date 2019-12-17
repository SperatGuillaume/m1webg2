<?php

namespace App\Controller\Site;

use App\Form\ContactType;
use App\Form\Model\ContactModel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ContactController extends AbstractController{
    /**
     * @Route("/contact", name="contact.form")
     */
    public function form(Request $request, \Swift_Mailer $mailer, Environment $twig):Response{

        $type = ContactType::class;
        $model = new ContactModel();

        $form = $this->createForm($type,$model);

        // handleRequest : répération des données en $_POST
        $form->handleRequest($request);

        // SI le formulaire est valide
        if($form->isSubmitted() && $form->isValid()){

            $this->addFlash('notice','Un email vous a été envoyé');

            return $this->redirectToRoute('contact.form');

        }
        return $this->render('public/contact/form.html.twig',[
            'form'=> $form->createView()
        ]);
    }
}