<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertyController extends AbstractController
{
    /**
     * @Route("/property", name="achats")
     */
    public function index(PropertyRepository $repo)
    {
        $maisons = $repo->findAllVisible();
        return $this->render('property/achats.html.twig',[
            'maisons' => $maisons
        ]);
    }

    /**
     * @Route("/bien/{id}", name="afficherBien", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function afficherBien(Property $property)
    {
        return $this->render('property/afficherBien.html.twig',[
            'maison' => $property
        ]);
    }

}
