<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Page Accueil (index)
 */
#[Route('/', name: 'app_')]
class IndexController extends AbstractController
{
    /**
     * Page Accueil (index)
     *
     * @return Response
     */
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('pages/index.html.twig');
    }
}
