<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Property;
use App\Form\ContactType;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Repository\PropertyRepository;
use App\Service\ContactNotification;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{
    /**
     * @Route("/property", name="achats")
     */
    public function index(PaginatorInterface $paginator, PropertyRepository $repo, Request $request)
    {
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);


        $maisons = $paginator->paginate(
            $repo->findAllVisibleQuery($search),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );
        return $this->render('property/achats.html.twig',[
            'maisons' => $maisons,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/bien/{id}", name="afficherBien", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function afficherBien(Property $property, Request $request, ContactNotification $notification)
    {
        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $notification->notify($contact);
            $this->addFlash('success', 'Votre email a bien été envoyé');
            return $this->redirectToRoute('afficherBien', [
                'id' => $property->getId()
            ]); 
        }

        return $this->render('property/afficherBien.html.twig',[
            'maison' => $property,
            'form' => $form->createView()
        ]);
    }

}
