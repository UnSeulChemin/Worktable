<?php

namespace App\Controller;

use App\Entity\Css;
use App\Repository\CssRepository;
use App\Form\CssFormType;
use App\Form\CssEditFormType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Page Css
 */
#[Route('/css', name: 'app_css_')]
class CssController extends AbstractController
{
    /**
     * Page Css, Read, Create
     *
     * @param Request $request
     * @param CssRepository $repository
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('', name: 'index')]
    public function indexCss(Request $request, CssRepository $repository, EntityManagerInterface $manager): Response
    {
        /* Read */
        $readsCss = $repository->findBy([], ['id' => 'DESC']);

        /* Create */
        $createCss = new Css();

        /* Create Form */
        $createFormCss = $this->createForm(CssFormType::class, $createCss);
        $createFormCss->handleRequest($request);

        if ($createFormCss->isSubmitted() && $createFormCss->isValid())
        {
            /* Get Data */
            $createCss = $createFormCss->getData();

            /* Treat Data */
            $manager->persist($createCss);
            $manager->flush();

            /* Flash Message */
            $this->addFlash('success', 'Your CSS message has been successfully sent !');

            /* Redirect */
            return $this->redirectToRoute('app_css_index');
        }

        else if ($createFormCss->isSubmitted() && !$createFormCss->isValid())
        {
            /* Flash Message */
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        /* Redirect */
        return $this->render('pages/css/css.html.twig', compact('createFormCss', 'readsCss'));
    }

    /**
     * Page Css, Update
     *
     * @param Request $request
     * @param Css $css
     * @param EntityManagerInterface $manager
     * @return Response
     */    
    #[Route('/update/{id}', name: 'update', methods: ['GET', 'POST'])]
    public function editCss(Request $request, Css $css, EntityManagerInterface $manager): Response
    {
        /* Edit === $css */

        /* Edit Form */
        $editFormCss = $this->createForm(CssEditFormType::class, $css);
        $editFormCss->handleRequest($request);

        if ($editFormCss->isSubmitted() && $editFormCss->isValid())
        {
            /* Get Data */
            $css = $editFormCss->getData();

            /* Treat Data */
            $manager->persist($css);
            $manager->flush();

            /* Flash Message */
            $this->addFlash('success', 'Your CSS message has been successfully updated !');

            /* Redirect */            
            return $this->redirectToRoute('app_css_index');
        }

        else if ($editFormCss->isSubmitted() && !$editFormCss->isValid())
        {
            /* Flash Message */
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        /* Redirect */
        return $this->render('pages/css/css_edit.html.twig', compact('editFormCss'));
    }

    /**
     * Page Css, Delete
     *
     * @param Css $css
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function deleteCss(Css $css, EntityManagerInterface $manager): Response
    {
        /* Get Data === $css */

        /* Treat Data */
        $manager->remove($css);
        $manager->flush();

        /* Flash Message */
        $this->addFlash('success', 'Your CSS message has been successfully delete !');

        /* Redirect */       
        return $this->redirectToRoute('app_css_index');
    }
}