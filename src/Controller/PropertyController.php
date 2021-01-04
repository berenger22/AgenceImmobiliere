<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PropertyController extends AbstractController
{
    /**
     * @Route("/property", name="achats")
     */
    public function index(PaginatorInterface $paginator, PropertyRepository $repo, Request $request)
    {
        $maisons = $paginator->paginate(
            $repo->findAllVisibleQuery(),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );
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
