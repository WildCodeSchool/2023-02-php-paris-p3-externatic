<?php

namespace App\Controller;

use App\Entity\Candidate;
use App\Entity\Company;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use App\Security\UserAuthenticator;
use Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class ConnectionController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home_index');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('connection/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): never
    {
        throw new Exception('Don\'t forget to activate logout in security.yaml');
    }

    #[Route('/register', name: 'register')]
    public function register(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        UserAuthenticator $authenticator,
        UserRepository $userRepository,
    ): Response {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $userRepository->save($user, true);

            $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );

            if ($user->getRoles()[0] === 'ROLE_CANDIDATE') {
                $user->setCandidate(new Candidate());
                $userRepository->save($user, true);

                return $this->redirectToRoute('candidate_new');
            } elseif ($user->getRoles()[0] === 'ROLE_COMPANY') {
                $user->setCompany(new Company());
                $userRepository->save($user, true);

                return $this->redirectToRoute('company_new');
            }
        }

        return $this->render('connection/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
