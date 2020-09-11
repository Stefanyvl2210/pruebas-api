<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;


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
     * @Route("/cake/{id}", name="cake", methods={"GET"})
     *  @param SerializerInterface $serializer
     * @param $id
     * @return JsonResponse
     */
    public function listCakes(SerializerInterface  $serializer,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $cake = $entityManager->getRepository(Cake::class)->collection();
        $response = $serializer->serialize($cake,'json');

        return new JsonResponse(json_decode($response));
    }

    /**
     * @Route("/cake", name="create_cake", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addCake(Request $request)
    {
        $content = $request->getContent();
        $json = json_decode($content, true);

        $entityManager = $this->getDoctrine()->getManager();
        $cake = new Cake($json['type'],$json['price']);
        $cake->setOrder(new Order($json['order']));
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($cake);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json([
            "message" => 'a cake has been added with id: '.$cake->getId(),
        ]);
    }

}
