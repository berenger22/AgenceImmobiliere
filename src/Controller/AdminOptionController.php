<?php

namespace App\Controller;

use App\Entity\Option;
use App\Form\OptionType;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/option")
 */
class AdminOptionController extends AbstractController
{
    /**
     * @Route("/", name="adminOptionIndex", methods={"GET"})
     */
    public function index(OptionRepository $optionRepository): Response
    {
        return $this->render('admin/option/index.html.twig', [
            'options' => $optionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="adminOptionNew", methods={"GET","POST"}, requirements={"id"="\d+"})
     * @Route("/{id}/edit", name="adminOptionEdit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function edit(Option $option = null, Request $request, EntityManagerInterface $em): Response
    {
        if(!$option){
            $option = new Option();
        }
        $form = $this->createForm(OptionType::class, $option);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $modif = $option->getId() != null;
            $em->persist($option);
            $em->flush();
            $this->addFlash('success', ($modif) ? "La modification a bien été effectué" : "La création a bien été effectué");
            return $this->redirectToRoute('adminOptionIndex');
        }

        return $this->render('admin/option/edit.html.twig', [
            'option' => $option,
            'form' => $form->createView(),
            "isModification" => $option->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="AdminOptionDelete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Request $request, Option $option, EntityManagerInterface $em): Response
    {
        if($this->isCsrfTokenValid("SUP". $option->getId(),$request->get('_token'))){
            $em->remove($option);
            $em->flush();
            $this->addFlash("success", "La suppression a été effectuée");
            return $this->redirectToRoute("adminOptionIndex");
        }
    }
}
