<?php

namespace App\Controller;

use App\Entity\Cake;
use App\Entity\Order;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
{
    /**
     * @Route("/", name="order")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/OrderController.php',
        ]);
    }
    /**
     * @Route("/order", name="list_orders", methods={"GET"})
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    public function listOrders(SerializerInterface  $serializer)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $order = $entityManager->getRepository(Order::class)->findAll();
        $response = $serializer->serialize($order,'json');

        return new JsonResponse(json_decode($response));
    }

    /**
     * @Route("/order", name="create_order", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function addOrder(Request $request)
    {
        $content = $request->getContent();
        $json = json_decode($content, true);

        $entityManager = $this->getDoctrine()->getManager();
        $order = new Order($json['number']);
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($order);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->json([
            "message" => 'an order has been added with id: '.$order->getId(),
            "order" => $order
        ]);
    }

    /**
     * @Route("/order/{id}", name="edit_order", methods={"PUT"})
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function editOrder(Request $request, $id)
    {
        $content = $request->getContent();
        $json = json_decode($content, true);

        $entityManager = $this->getDoctrine()->getManager();
        $order = $entityManager->getRepository(Order::class)->find($id);

        if (!$order) {
            return $this->json([
                "message" => 'No order found for id '.$id
            ]);
        }
        $order = $order->update($json);
        $entityManager->flush();

        if($order->getNumber() == $json['number']){
            return $this->json([
                "message" => 'An order has been changed with id: '.$order->getId(),
                "order" => $order
            ]);
        }
        return $this->json([
            "message" => 'Nothing has been changed'
        ]);
    }

    /**
     * @Route("/order/{id}", name="delete_order", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function deleteOrder($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $order = $entityManager->getRepository(Order::class)->find($id);
        if (!$order) {
            return $this->json([
                "message" => 'No order found for id '.$id
            ]);
        }
        $entityManager->remove($order);
        $entityManager->flush();
        return $this->json([
            "message" => 'An order has been removed with id '.$id
        ]);
    }
}
