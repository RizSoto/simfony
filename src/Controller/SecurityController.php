<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $requeteHttp, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder): Response
    {
        //Création d'un utilisateur vide
        $utilisateur = new Utilisateur();

        // création d'un objet formulaire pour ajouter un utilisateur
        $formulaireUtilisateur=$this->createForm(UtilisateurType::class, $utilisateur);

            $formulaireUtilisateur->handleRequest($requeteHttp);

            if($formulaireUtilisateur->isSubmitted() && $formulaireUtilisateur->isValid())
            {

                //Attribuer un rôle au nouvel utilisateur

                $utilisateur->setRoles(['ROLE_USER']);

                //Encoder le mot de passe de l'utilisateur
                $encodagePassword = $encoder->encodePassword($utilisateur, $utilisateur->getPassword());
                $utilisateur->setPassword($encodagePassword);

                // Enregistrer l'utilisateur en BD
                $manager->persist($utilisateur);
                $manager->flush();
                // Rediriger l’utilisateur
                return $this->redirectToRoute('app_login');
            }

            return $this->render('security/inscription.html.twig', ['vueFormulaireUtilisateur' => $formulaireUtilisateur -> createView()]);
    }
}
