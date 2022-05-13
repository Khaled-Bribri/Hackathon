<?php

namespace App\Controller;

use App\Model\ProductManager;
use DateTime;

class ProductController extends AbstractController
{
    public function addProduct()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productManager = new ProductManager();
            $dateCreation = new DateTime();
            $name = $_POST['name'];
            $DateCreation = $dateCreation->format('Y-m-d H:i:s');
            $DateExpiration = $_POST['DateExpiration'];
            $productManager->insert($name, $DateCreation, $DateExpiration);
            header('Location: /products/listproduct');
            return $this->twig->render('Home/index.html.twig');
        }

        return $this->twig->render('product/add.html.twig');
    }

    public function listproduct()
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();
        return $this->twig->render('product/list.html.twig', ['products' => $products]);
    }

    public function editproduct($id)
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
