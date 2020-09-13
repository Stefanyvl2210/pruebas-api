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


class CakeController extends AbstractController
{
    /**
     * @Route("/api/index", name="index")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/CakesController.php',
        ]);
    }

    /**
     * @Route("/api/cake", name="list_cakes", methods={"GET"})
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function listCakes(SerializerInterface  $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $cake = $entityManager->getRepository(Cake::class)->findAll();
        $response = $serializer->serialize($cake,'json');
        return new JsonResponse(json_decode($response));
    }


    /**
     * @Route("/api/cake", name="create_cake", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addCake(Request $request)
    {
        dd($request->getUser());

        $content = $request->getContent();
        $json = json_decode($content,true);//when is true returns objects in array associative

        $entityManager = $this->getDoctrine()->getManager();
        $cake = new Cake($json['type'],$json['price']);
        $cake->setOrder($json['order']);
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($cake);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json([
            "message" => 'a cake has been added with id: '.$cake->getId(),
            "cake" => $cake
        ]);
    }

    /**
     * @Route("/api/cake/{id}", name="edit_cake", methods={"PUT"})
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function editCake(Request $request, $id)
    {
        $content = $request->getContent();
        $json = json_decode($content, true);

        $entityManager = $this->getDoctrine()->getManager();
        $cake = $entityManager->getRepository(Cake::class)->find($id);

        if (!$cake) {
            return $this->json([
                "message" => 'No cake found for id '.$id
            ]);
        }
        $cake = $cake->update($json);
        $entityManager->flush();

        if($cake->getType() == $json['type'] || $cake->getPrice() == $json['price']){
            return $this->json([
                "message" => 'A cake has been changed with id: '.$cake->getId(),
                "cake" => $cake
            ]);
        }
        return $this->json([
            "message" => 'Nothing has been changed'
        ]);
    }

    /**
     * @Route("/api/cake/{id}", name="delete_cake", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function deleteCake($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $cake = $entityManager->getRepository(Cake::class)->find($id);
        if (!$cake) {
            return $this->json([
                "message" => 'No cake found for id '.$id
            ]);
        }
        $entityManager->remove($cake);
        $entityManager->flush();
        return $this->json([
            "message" => 'A cake has been removed with id '.$id
        ]);
    }

}
