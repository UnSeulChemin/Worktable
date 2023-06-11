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
        /* Fetch Current User, Relation OneToMany */
        $user = $this->getUser()->getId();

        /* Read */
        $readCss = $repository->findBy(['user' => $user], ['id' => 'DESC']);

        /* Create */
        $createCss = new Css();

        /* Create, Relation ManyToOne, GetUserId */
        $createCss->setUser($this->getUser());

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
        return $this->render('pages/css/css.html.twig', compact('createFormCss', 'readCss'));
    }
 
    /**
     * Page Css, Update
     *
     * @param Request $request
     * @param Css $updateCss
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/update/{id}', name: 'update', methods: ['GET', 'POST'])]
    public function updateCss(Request $request, Css $updateCss, EntityManagerInterface $manager): Response
    {
        /* Get Data === $updateCss */

        /* Update Form */
        $updateFormCss = $this->createForm(CssEditFormType::class, $updateCss);
        $updateFormCss->handleRequest($request);

        if ($updateFormCss->isSubmitted() && $updateFormCss->isValid())
        {
            /* UpdatedAt */
            $updateCss->setUpdatedAt(new \DateTimeImmutable());

            /* Get Data */
            $updateCss = $updateFormCss->getData();

            /* Treat Data */
            $manager->persist($updateCss);
            $manager->flush();

            /* Flash Message */
            $this->addFlash('success', 'Your CSS message has been successfully updated !');

            /* Redirect */            
            return $this->redirectToRoute('app_css_index');
        }

        else if ($updateFormCss->isSubmitted() && !$updateFormCss->isValid())
        {
            /* Flash Message */
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        /* Redirect */
        return $this->render('pages/css/css_edit.html.twig', compact('updateFormCss'));
    }

    /**
     * Page Css, Delete
     *
     * @param Css $deleteCss
     * @param EntityManagerInterface $manager
     * @return Response
     */
    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function deleteCss(Css $deleteCss, EntityManagerInterface $manager): Response
    {
        /* Get Data === $deleteCss */

        /* Treat Data */
        $manager->remove($deleteCss);
        $manager->flush();

        /* Flash Message */
        $this->addFlash('success', 'Your CSS message has been successfully delete !');

        /* Redirect */       
        return $this->redirectToRoute('app_css_index');
    }
}