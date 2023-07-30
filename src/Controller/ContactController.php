<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET','POST'])]
    public function index(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $formService->handleForm($form);
            $contactRepository->save($contact, true);
            return $this->json([
                'message' => 'Nous avons bien reçus votre message, nous reviendrons vers vous aussi vite que possible'
            ]);
        }

        // Gestion en AJAX de la soumission du formulaire
//        $contact = new Contact();
//        $data = $request->get('contact');
//        $contact
//            ->setName($data['name'])
//            ->setEmail($data['email'])
//            ->setMessage($data['message'])
//            ->setLastName($data['lastName'])
//            ->setPhone($data['phone'])
//            ->setSubject($data['subject']);

        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }

    public function form() {
        $form = $this->createForm(ContactType::class);
        return $this->render('contact/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
