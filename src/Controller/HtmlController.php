<?php

namespace App\Controller;

use App\Entity\Html;
use App\Form\HtmlFormType;
use App\Form\HtmlEditFormType;
use App\Repository\HtmlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/html', name: 'app_html_')]
class HtmlController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(Request $request, EntityManagerInterface $manager, HtmlRepository $repository): Response
    {
        // Read
        $readsHtml = $repository->findBy([], ['id' => 'DESC']);

        // Create
        $createHtml = new Html();

        $form = $this->createForm(HtmlFormType::class, $createHtml);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $createHtml = $form->getData();

            $manager->persist($createHtml);
            $manager->flush();

            $this->addFlash('success', 'Your HTML message have been successfully sent !');
            return $this->redirectToRoute('app_html_index');
        }

        else if ($form->isSubmitted() && !$form->isValid())
        {
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        return $this->render('pages/html/html.html.twig', compact('form', 'readsHtml'));
    }



    #[Route('/update/{id}', name: 'update', methods: ['GET', 'POST'])]
    public function editUsers(Request $request, Html $html, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(HtmlEditFormType::class, $html);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $html = $form->getData();

            $manager->persist($html);
            $manager->flush();

            return $this->redirectToRoute('app_html_index');
        }

        return $this->render('pages/html/html_edit.html.twig', compact('form'));
    }


    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function deleteUsers(Html $html, EntityManagerInterface $manager): Response
    {
        $manager->remove($html);
        $manager->flush();

        $this->addFlash('success', 'Your HTML message have been successfully delete !');
        return $this->redirectToRoute('app_html_index');
    }

}