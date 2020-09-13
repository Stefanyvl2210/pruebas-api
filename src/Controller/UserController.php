<?php

namespace App\Controller;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    /**
     * @Route("/register", name="register_user", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     */
    public function registerUser(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $content = $request->getContent();
        $json = json_decode($content,true);//when is true returns objects in array associative

        $email = $json['email'];
        $password = $json['password'];
        if (!$password || !$email){
            return $this->json([
                "message" => 'Invalid email or password'
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $user = new User($email,$password);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            "message" => 'An user has been registered with email: '.$user->getEmail(),
        ]);
    }

    /**
     * @Route("/admin/delete_user/{id}", name="delete_user", methods={"DELETE"})
     * @param $id
     * @return JsonResponse
     */
    public function deleteUser($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        if (!$user) {
            return $this->json([
                "message" => 'No user found for id '.$id
            ]);
        }
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->json([
            "message" => 'An user has been removed with id '.$id
        ]);
    }
}
