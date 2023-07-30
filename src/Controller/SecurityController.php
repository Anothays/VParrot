<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

          return $this->render(
              'security/login.html.twig',
//              '@EasyAdmin/page/login.html.twig',
              [
              // parameters usually defined in Symfony login forms
              'error' => $error,
              'last_username' => $lastUsername,

              // OPTIONAL parameters to customize the login form:

              // the translation_domain to use (define this option only if you are
              // rendering the login template in a regular Symfony controller; when
              // rendering it from an EasyAdmin Dashboard this is automatically set to
              // the same domain as the rest of the Dashboard)
//              'translation_domain' => 'admin',

              // by home EasyAdmin displays a black square as its home favicon;
              // use this method to display a custom favicon: the given path is passed
              // "as is" to the Twig asset() function:
              // <link rel="shortcut icon" href="{{ asset('...') }}">
//              'favicon_path' => '/favicon-admin.svg',

              // the title visible above the login form (define this option only if you are
              // rendering the login template in a regular Symfony controller; when rendering
              // it from an EasyAdmin Dashboard this is automatically set as the Dashboard title)
//              'page_title' => 'ACME login',

              // the string used to generate the CSRF token. If you don't define
              // this parameter, the login form won't include a CSRF token
              'csrf_token_intention' => 'authenticate',

              // the URL users are redirected to after the login (home: '/admin')
              'target_path' => $this->generateUrl('admin'),

              // the label displayed for the username form field (the |trans filter is applied to it)
              'username_label' => 'Email',

              // the label displayed for the password form field (the |trans filter is applied to it)
              'password_label' => 'Mot de passe',

              // the label displayed for the Sign In form button (the |trans filter is applied to it)
              'sign_in_label' => 'Se connecter',

              // the label displayed for the Sign Up form button (the |trans filter is applied to it)
//              'sign_up_label' => 'S\'inscrire',

              // the 'name' HTML attribute of the <input> used for the username field (home: '_username')
              'username_parameter' => 'email',

              // the 'name' HTML attribute of the <input> used for the password field (home: '_password')
              'password_parameter' => 'password',

              // whether to enable or not the "forgot password?" link (home: false)
              'forgot_password_enabled' => false,

              // the path (i.e. a relative or absolute URL) to visit when clicking the "forgot password?" link (home: '#')
//              'forgot_password_path' => $this->generateUrl('...', []),

              // the label displayed for the "forgot password?" link (the |trans filter is applied to it)
//              'forgot_password_label' => 'Forgot your password?',

              // whether to enable or not the "remember me" checkbox (home: false)
//              'remember_me_enabled' => false,

              // remember me name form field (home: '_remember_me')
//              'remember_me_parameter' => 'custom_remember_me_param',

              // whether to check by home the "remember me" checkbox (home: false)
//              'remember_me_checked' => true,

              // the label displayed for the remember me checkbox (the |trans filter is applied to it)
//              'remember_me_label' => 'Remember me',
          ]);

    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
