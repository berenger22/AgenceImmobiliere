<?php 
namespace App\Controller;

use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin/picture")
 */
class AdminPictureController extends AbstractController {

    /**
     * @Route("/{id}", name="adminPictureDelete", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function delete(Picture $picture, Request $request, EntityManagerInterface $em)
    {
        $data = json_decode($request->getContent(), true);
        if($this->isCsrfTokenValid('delete'. $picture->getId(), $data['_token'])){
            $em->remove($picture);
            $em->flush();
            $this->addFlash("success", "La suppression a été effectuée");
            return new JsonResponse(['success' => 1]);
        }
        return new JsonResponse(['error' => 'Token Invalide'], 400);
    }
}