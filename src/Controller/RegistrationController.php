<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Page Register
 */
#[Route('/inscription', name: 'app_')]
class RegistrationController extends AbstractController
{
    /**
     * Page Register, Create
     *
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasher
     * @param UserAuthenticatorInterface $userAuthenticator
     * @param UserAuthenticator $authenticator
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('', name: 'register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator, UserAuthenticator $authenticator,
        EntityManagerInterface $entityManager): Response
    {
        /* Create */
        $createUser = new User();

        /* Create Form */
        $createFormUser = $this->createForm(RegistrationFormType::class, $createUser);
        $createFormUser->handleRequest($request);

        if ($createFormUser->isSubmitted() && $createFormUser->isValid())
        {
            /* Get Data */
            // encode the plain password
            $createUser->setPassword(
                $userPasswordHasher->hashPassword(
                    $createUser,
                    $createFormUser->get('plainPassword')->getData()
                )
            );

            /* Treat Data */
            $entityManager->persist($createUser);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $userAuthenticator->authenticateUser(
                $createUser,
                $authenticator,
                $request
            );
        }

        else if ($createFormUser->isSubmitted() && !$createFormUser->isValid())
        {
            /* Flash Message */
            $this->addFlash('warning', 'Complete the following step and try again.');
        }

        /* Redirect */
        return $this->render('pages/security/register.html.twig', [
            'registrationForm' => $createFormUser->createView(),
        ]);
    }
}