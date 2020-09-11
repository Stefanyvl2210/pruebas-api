<?php

namespace App\Controller;

use App\Entity\Cakes;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;


class CakesController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CakesController.php',
        ]);
    }

    /**
     * @Route("/cakes", name="cakes",methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function listCakes(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $cake = new Cakes();

        return $this->json([
            'cakes' => $cake
        ]);
    }

    /**
     * @Route("/addCake", name="create_cake", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addCake(Request $request)
    {
        $content = $request->getContent();
        $json = json_decode($content, true);

        $entityManager = $this->getDoctrine()->getManager();
        $cake = new Cakes($json['type'],$json['price']);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($cake);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json([
            "message" => 'a cake has been added with id: '.$cake->getId(),
        ]);
    }

}
