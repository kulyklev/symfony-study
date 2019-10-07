<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/*
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /*
     * @Route("/", name="default_name")
     */
    public function index()
    {
        return new JsonRresponse([
            'action' => 'index',
            'time' => time(),
        ]);
    }
}