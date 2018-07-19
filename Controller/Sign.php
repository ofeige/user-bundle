<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Bywulf\UserBundle\Form\Type\UserType;
use Bywulf\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class Sign extends Controller
{
    /**
     * @Route("/user/login", name="bywulf_user_login")
     *
     * @param AuthenticationUtils $authUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('User/sign/signin.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error
        ));
    }

    /**
     * @Route("/user/register", name="bywulf_user_registration")
     *
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('user_registration_successful');
        }

        return $this->render(
            'User/sign/signup.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/register/successful", name="bywulf_user_registration_successful")
     *
     * @return Response
     */
    public function registerSuccessfulAction()
    {
        return $this->render('User/sign/signup_successful.html.twig');
    }

    /**
     * @Route("/user/forgotpw", name="bywulf_user_forgot_password"
     *
     * @return Response
     */
    public function forgotPassword()
    {
        return $this->render('User/sign/forgot_password.html.twig');
    }
}
