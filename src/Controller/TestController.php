<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{

  /**
   * @Route("/test", name="test_route", methods={"POST"})
   * @param Request $request
   * @return Response
   */
  public function test(Request $request) : Response {
    $data = json_decode((string)$request->getContent(), true);
    return new Response(json_encode($data), 200, ['Content-Type' => 'application/json; charset=utf-8', 'Access-Control-Allow-Origin' => '*']);

  }

}