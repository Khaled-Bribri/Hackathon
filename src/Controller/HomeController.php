<?php

namespace App\Controller;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Psr16Cache;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        $logger     = new \Monolog\Logger('test');
        $httpClient = new \GuzzleHttp\Client();
        $psr6Cache  = new FilesystemAdapter();
        $psr16Cache = new Psr16Cache($psr6Cache);
        $api        = new \OpenFoodFacts\Api('food', 'fr', $logger, $httpClient, $psr16Cache);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $search = $_POST['search'];
            $product    = $api->getProduct($search);
            $productDataAsArray = $product->getData();
            return $this->twig->render('Home/index.html.twig', [
            'product' => $productDataAsArray]);
        }
        return $this->twig->render('Home/index.html.twig');
    }
}
