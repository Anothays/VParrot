<?php

namespace App\Controller;

use App\Entity\ContactMessage;
use App\Form\ContactMessageType;
use App\Repository\ContactMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET','POST'])]
    public function index(Request $request, ContactMessageRepository $contactRepository): Response
    {
        $contact = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $formService->handleForm($form);
            $contactRepository->save($contact, true);
            return $this->json([
                'message' => 'Nous avons bien reçus votre message, nous reviendrons vers vous aussi vite que possible'
            ]);
        }


        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }

    public function form() {
        $form = $this->createForm(ContactMessageType::class);
        return $this->render('contact/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
