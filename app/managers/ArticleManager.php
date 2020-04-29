<?php

namespace App\Managers;

use App\Config\ConnexionDB;
use App\Models\Article;

class ArticleManager
{

    private $_db = null;

    public function __construct()
    {
        $this->_db = ConnexionDB::getInstance();
    }

    public function save(Article $article)
    {
        try {
            $req = $this->_db->prepare('INSERT INTO article (id, libelle, prix, quantite) VALUES (:id, :libelle, :prix, :quantite)');
            $req->bindValue(':id', $article->getId(), \PDO::PARAM_STR);
            $req->bindValue(':libelle', $article->getLibelle(), \PDO::PARAM_STR);
            $req->bindValue(":prix", $article->getPrix(), \PDO::PARAM_STR);
            $req->bindValue(":quantite", $article->getQuantite(), \PDO::PARAM_STR);
            $req->execute();
            return $this->_db->lastInsertId();
        } catch (\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return -1;
    }

    public function findAll()
    {
        try {
            $comptes = [];
            $req = $this->_db->query('select * from article');
            while ($res = $req->fetch(\PDO::FETCH_ASSOC)) {
                $perso = new Article($res);
                $comptes[] = $perso;
            }
            return $comptes;
        } catch (\PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
        return [];
    }
}