<?php

namespace App\Controller;

use App\Entity\Html;
use App\Repository\HtmlRepository;
use App\Form\HtmlFormType;
use App\Form\HtmlEditFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Page Html
 */
#[Route('/html', name: 'app_html_')]
class HtmlController extends AbstractController
{

    /**
     * Page Html, Read, Create
     *
     * @param Request $request
     * @param HtmlRepository $repository
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('', name: 'index')]
    public function indexHtml(Request $request, HtmlRepository $repository, EntityManagerInterface $manager): Response
    {
        /* Read */
        $readsHtml = $repository->findBy([], ['id' => 'DESC']);

        /* Create */
        $createHtml = new Html();

        /* Create Form */
        $createFormHtml = $this->createForm(HtmlFormType::class, $createHtml);
        $createFormHtml->handleRequest($request);

        if ($createFormHtml->isSubmitted() && $createFormHtml->isValid())
        {
            /* Get Data */
            $createHtml = $createFormHtml->getData();

            /* Treat Data */
            $manager->persist($createHtml);
            $manager->flush();

            /* Flash Message */
            $this->addFlash('success', 'Your HTML message has been successfully sent !');

            /* Redirect */
            return $this->redirectToRoute('app_html_index');
        }

        else if ($createFormHtml->isSubmitted() && !$createFormHtml->isValid())
        {
            /* Flash Message */
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        /* Redirect */
        return $this->render('pages/html/html.html.twig', compact('createFormHtml', 'readsHtml'));
    }

    /**
     * Page Html, Update
     *
     * @param Request $request
     * @param Html $html
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/update/{id}', name: 'update', methods: ['GET', 'POST'])]
    public function editHtml(Request $request, Html $html, EntityManagerInterface $manager): Response
    {
        /* Edit === $html */

        /* Edit Form */
        $editFormHtml = $this->createForm(HtmlEditFormType::class, $html);
        $editFormHtml->handleRequest($request);

        if ($editFormHtml->isSubmitted() && $editFormHtml->isValid())
        {
            /* Get Data */
            $html = $editFormHtml->getData();

            /* Treat Data */
            $manager->persist($html);
            $manager->flush();

            /* Flash Message */
            $this->addFlash('success', 'Your HTML message has been successfully updated !');

            /* Redirect */            
            return $this->redirectToRoute('app_html_index');
        }

        else if ($editFormHtml->isSubmitted() && !$editFormHtml->isValid())
        {
            /* Flash Message */
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        /* Redirect */
        return $this->render('pages/html/html_edit.html.twig', compact('editFormHtml'));
    }

    /**
     * Page Html, Delete
     *
     * @param Html $html
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function deleteHtml(Html $html, EntityManagerInterface $manager): Response
    {
        /* Get Data === $html */

        /* Treat Data */
        $manager->remove($html);
        $manager->flush();

        /* Flash Message */
        $this->addFlash('success', 'Your HTML message has been successfully delete !');

        /* Redirect */       
        return $this->redirectToRoute('app_html_index');
    }

}