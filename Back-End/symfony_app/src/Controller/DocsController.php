<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DocsController extends AbstractController {

    /**
     * @Route("/", methods={"GET"})
     */
    public function getUsers(): Response {

        return $this->render('documentation/docs.html.twig');
    }

}