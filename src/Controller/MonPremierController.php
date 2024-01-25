<?php

namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonPremierController
{

    /**
     * @Route("/index")
     * 
     * @return Response
     */
    public function maPremierReponse()
    {
        $maReponse = new Response();
        $maReponse->setStatusCode( code: Response::HTTP_OK);
        $maReponse->headers->set( key: 'Content-Type', values: 'text/html');
        $maReponse->setContent( content: '<html><title>Reponse</title><body>Resultat d\'un objet reponse</body></html>');
        return $maReponse;
    }
}
