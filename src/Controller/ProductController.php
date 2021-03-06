<?php

namespace App\Controller;

use App\Model\ProductManager;
use DateTime;
use App\Service\Mailer;

class ProductController extends AbstractController
{
    public function addProduct()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productManager = new ProductManager();
            $dateCreation = new DateTime();
            $name = $_POST['name'];
            $dateCreation = $dateCreation->format('Y-m-d H:i:s');
            $dateExpiration = $_POST['DateExpiration'];
            $productManager->insert($name, $dateCreation, $dateExpiration);
            header('Location: /products/listproduct');
            return $this->twig->render('Home/index.html.twig');
        }

        return $this->twig->render('product/add.html.twig');
    }

    public function listProduct()
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();

        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'send_alert') {
            $user = 'marx.hugo@gmail.com';
            $productManager = new ProductManager();
            $limitProducts = $productManager->checkLimiteDate();

            $listeProduits = '';
            foreach ($limitProducts as $item) {
                $listeProduits .= '<li>' . $item['name'] .
                 ' - Date limite de consommation : ' . $item['DateExpiration'] . '</li>';
            }

            $message = 'Bonjour Yecin, <br>
            Certains produits dans votre frigo arrivent au terme de leur date limite de consommation,
             n\'oubliez pas de les manger !
            <ul>' . $listeProduits . '</ul> <br>
            Bonne journée !';

            $mailer = new Mailer();
            $mailer->sendMail($user, $message);
        }
        return $this->twig->render('product/list.html.twig', ['products' => $products]);
    }

    public function editProduct($id)
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productManager->update($_POST);
            header('Location: /products/listproduct');
            return $this->twig->render('product/list.html.twig');
        }

        return $this->twig->render('product/edit.html.twig', ['product' => $product]);
    }

    public function deleteproduct($id)
    {
        $productManager = new ProductManager();
        $productManager->delete($id);
        header('Location: /products/listproduct');
        return $this->twig->render('product/list.html.twig');
    }
}
