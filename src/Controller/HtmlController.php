<?php

namespace App\Controller;

use App\Entity\Html;
use App\Form\HtmlFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HtmlController extends AbstractController
{
    #[Route('/html', name: 'app_html')]
    public function index(Request $request, EntityManagerInterface $manager): Response
    {
        $html = new Html();

        $form = $this->createForm(HtmlFormType::class, $html);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $html = $form->getData();

            $manager->persist($html);
            $manager->flush();

            $this->addFlash('success', 'Your HTML message have been successfully sent !');
            return $this->redirectToRoute('app_html');
        }

        else if ($form->isSubmitted() && !$form->isValid())
        {
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        return $this->render('pages/html/html.html.twig', compact('form'));
    }
}
