<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController
{
    /**
     * Page d'accueil
     * 
     * @Route("/", name="homepage", methods={"GET"})
     */
    public function index() :Response
    {
        return $this->render('default/index.html.twig');
    }

}
