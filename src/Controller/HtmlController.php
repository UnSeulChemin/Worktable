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
        $readHtml = $repository->findBy([], ['id' => 'DESC']);

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
        return $this->render('pages/html/html.html.twig', compact('createFormHtml', 'readHtml'));
    }

    /**
     * Page Html, Update
     *
     * @param Request $request
     * @param Html $updateHtml
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/update/{id}', name: 'update', methods: ['GET', 'POST'])]
    public function updateHtml(Request $request, Html $updateHtml, EntityManagerInterface $manager): Response
    {
        /* Get Data === $updateHtml */

        /* Update Form */
        $updateFormHtml = $this->createForm(HtmlEditFormType::class, $updateHtml);
        $updateFormHtml->handleRequest($request);

        if ($updateFormHtml->isSubmitted() && $updateFormHtml->isValid())
        {
            /* Get Data */
            $updateHtml = $updateFormHtml->getData();

            /* Treat Data */
            $manager->persist($updateHtml);
            $manager->flush();

            /* Flash Message */
            $this->addFlash('success', 'Your HTML message has been successfully updated !');

            /* Redirect */            
            return $this->redirectToRoute('app_html_index');
        }

        else if ($updateFormHtml->isSubmitted() && !$updateFormHtml->isValid())
        {
            /* Flash Message */
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        /* Redirect */
        return $this->render('pages/html/html_edit.html.twig', compact('updateFormHtml'));
    }

    /**
     * Page Html, Delete
     *
     * @param Html $deleteHtml
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function deleteHtml(Html $deleteHtml, EntityManagerInterface $manager): Response
    {
        /* Get Data === $deleteHtml */

        /* Treat Data */
        $manager->remove($deleteHtml);
        $manager->flush();

        /* Flash Message */
        $this->addFlash('success', 'Your HTML message has been successfully delete !');

        /* Redirect */       
        return $this->redirectToRoute('app_html_index');
    }
}