<?php


namespace App\Controller;


use App\Service\ESClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrackController extends AbstractController
{

  /**
   * @var ESClient
   */
  private $esClient;

  public function __construct(ESClient $esClient)
  {
    $this->esClient = $esClient;
  }

  /**
   * @Route("/track", name="track_route", methods={"POST"})
   * @param Request $request
   * @return Response
   */
  public function test(Request $request) : Response {
    $data = json_decode((string)$request->getContent(), true);
    $doc = [
      'date' => (new \DateTime())->setTimezone(new \DateTimeZone('UTC'))->format('Y-m-d\TH:i:s'),
      'fingerprint' => $data['fingerprint'],
      'ip' => $request->getClientIp(),
      'path' => $data['browsingData']['path'],
      'query' => $data['browsingData']['query'],
      'screensize' => $data['browsingData']['screenWidth'] . 'x' . $data['browsingData']['screenHeight'],
      'tags' => [],
      'useragent' => $data['browsingData']['browserInfo']['userAgent'],
      'domain' => $data['browsingData']['host'],
      'browserName' => $data['browsingData']['browserInfo']['browserName'],
      'browserVersion' => $data['browsingData']['browserInfo']['majorVersion'],
    ];
    $this->esClient->index('digipol', $doc);
    return new Response(/*json_encode(['status' => 'ok'])*/json_encode($doc), 200, ['Content-Type' => 'application/json; charset=utf-8', 'Access-Control-Allow-Origin' => '*']);

  }

}