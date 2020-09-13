<?php

namespace App\Controller;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/auth", name="auth")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }

    /**
     * @Route("/signup",name="signup",methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     */
    public function signup(Request $request,UserPasswordEncoderInterface $encoder){
        $data = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setEmail($data->email);
        $user->setPassword($encoder->encodePassword($user, $data->password));
        $em->persist($user);
        $em->flush();

        return new JsonResponse([
            'Success' => 'An user has been created'
        ]);
    }

    /**
     * @Route("/login",name="login",methods={"POST"})
     * @param Request $request
     * @param JWTTokenManagerInterface $JWT
     * @return JsonResponse
     */
    public function login(Request $request,JWTTokenManagerInterface $JWT){
        $data = json_decode($request->getContent());
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(["email" => $data->email]);

        return $this->json([
            "token" => $JWT->create($user)
        ]);
    }

    /**
     * @Route("/api/protected",name="protected",methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function protected(Request $request){

        return $this->json([
            "response" => 'here protected'
        ]);
    }

}
