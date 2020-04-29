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
            $req->bindValue(':prix', $article->getPrix(), \PDO::PARAM_STR);
            $req->bindValue(':quantite', $article->getQuantite(), \PDO::PARAM_STR);
            $req->execute();
            return $this->_db->lastInsertId();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function findAll()
    {
        try {
            $comptes = [];
            $req = $this->_db->query('SELECT * FROM article');
            while ($res = $req->fetch(\PDO::FETCH_ASSOC)) {
                $perso = $res;
                $comptes[] = $perso;
            }
            return $comptes;
        } catch (\PDOException $e) {
            throw $e;
        }
        return [];
    }
    
    public function findOneById($id)
    {
        try {
            $req = $this->_db->prepare('SELECT * FROM article WHERE id = :id');
            $req->bindValue(':id', $id, \PDO::PARAM_INT);
            $req->execute();
            $res = $req->fetch(\PDO::FETCH_ASSOC);
            return $res;
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function remove($id)
    {
        try {
            $req = $this->_db->prepare('DELETE FROM article WHERE id = :id');
            $req->bindValue(':id', $id, \PDO::PARAM_INT);
            return $req->execute();
        } catch (\PDOException $e) {
            throw $e;
        }
    }

    public function update(Article $article)
    {
        try {
            $req = $this->_db->prepare('UPDATE article SET libelle = :libelle, prix = :prix,  quantite = :quantite  WHERE id = :id');
            $req->bindValue(':id', $article->getId(), \PDO::PARAM_STR);
            $req->bindValue(':libelle', $article->getLibelle(), \PDO::PARAM_STR);
            $req->bindValue(':prix', $article->getPrix(), \PDO::PARAM_STR);
            $req->bindValue(':quantite', $article->getQuantite(), \PDO::PARAM_STR);
            if ($req->execute()) {
                return $article;
            }
        } catch (\PDOException $e) {
            throw $e;
        }
        return null;
    }
}