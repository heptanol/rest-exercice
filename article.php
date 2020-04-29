<?php

use App\Managers\ArticleManager;
use App\Models\Article;

require "vendor/autoload.php";

$request_method = $_SERVER["REQUEST_METHOD"];

$am = new ArticleManager();


switch($request_method)
{
    case 'GET':
        if(!empty($_GET["id"]))
        {
            // Récupérer un seul produit
            $id = intval($_GET["id"]);
            header('Content-Type: application/json');
            echo json_encode($am->findOneById($id));
        }
        else {
            // Récupérer tous les produits
            header('Content-Type: application/json');
            echo json_encode($am->findAll());
        }

            break;
    case 'POST':
        $json = file_get_contents('php://input');
        $data = (array) json_decode($json);
        $article = new Article();
        $article->setLibelle($data['libelle']);
        $article->setPrix($data['prix']);
        $article->setQuantite($data['quantite']);
        $data['id'] = $am->save($article);
        header('Content-Type: application/json');
        echo json_encode($data);
        break;
    case 'PUT':
        $json = file_get_contents('php://input');
        $data = (array) json_decode($json);

        $article = new Article();
        $id = intval($_GET["id"]);
        $article->setId($id);
        $article->setLibelle($data['libelle']);
        $article->setPrix($data['prix']);
        $article->setQuantite($data['quantite']);

        $am->update($article);
        $data['id'] = $id;
        header('Content-Type: application/json');
        echo json_encode($data);
        break;
    case 'DELETE':
        $id = intval($_GET["id"]);
        header('Content-Type: application/json');
        echo json_encode($am->remove($id));
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}




