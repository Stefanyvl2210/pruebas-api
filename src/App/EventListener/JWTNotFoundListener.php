<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTNotFoundEvent;
use Symfony\Component\HttpFoundation\JsonResponse;


class JWTNotFoundListener{
    /**
     * @param JWTNotFoundEvent $event
     */
    public function onJWTNotFound(JWTNotFoundEvent $event)
    {
        $data = [
            'status'  => 403,
            'message' => 'You are not authorized, please login',
        ];

        $response = new JsonResponse($data, 403);

        $event->setResponse($response);
    }
}
