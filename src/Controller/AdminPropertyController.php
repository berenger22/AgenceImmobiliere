<?php

namespace App\Controller;

use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminPropertyController extends AbstractController
{
    /**
     * @Route("/", name="adminProperty")
     */
    public function index(PropertyRepository $repo): Response
    {
        $properties = $repo->findAll();
        return $this->render('admin/property/adminProperty.html.twig', [
            'maisons' => $properties
        ]);
    }

    /**
     * @Route("/create", name="adminPropertyCreate", methods={"GET","POST"}, requirements={"id"="\d+"})
     * @Route("/property/{id}", name="adminPropertyEdit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Property $property = null, Request $request, EntityManagerInterface $em): Response
    {
        if(!$property){
            $property = new Property();
        }

        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $modif = $property->getId() !== null;
            $em->persist($property);
            $em->flush();
            $this->addFlash('success', ($modif) ? "La modification a bien été effectué" : "La création a bien été effectué");
            return $this->redirectToRoute("adminProperty");
        }
        return $this->render('admin/property/edit.html.twig', [
            'maison' => $property,
            'form' => $form->createView(),
            "isModification" => $property->getId() !== null
        ]);
    }

    /**
     * 
     * @Route("/property/{id}", name="adminPropertyDelete", methods={"delete"}, requirements={"id"="\d+"})
     */
    public function delete(Property $property, Request $request, EntityManagerInterface $em)
    {
        if($this->isCsrfTokenValid("SUP". $property->getId(),$request->get('_token'))){
            $em->remove($property);
            $em->flush();
            $this->addFlash("success", "La suppression a été effectuée");
            return $this->redirectToRoute("adminProperty");
        }
    }
}
