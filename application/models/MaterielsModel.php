<?php
namespace app\models;
defined('F3IL') or die('Accès Interdit');

use \f3il\Error;
	Class MaterielsModel{

		/**
     	* Instance du modèle
     	*/
		public static function getAll(){
			$pdo = \f3il\Database::getInstance();

			$req = $pdo->prepare("SELECT * FROM formulaire ORDER BY description");
			try{
				$req->execute();
				$data = $req->fetchAll(\PDO::FETCH_ASSOC);
			} catch(\PDOException $e){
				//die("Erreur SQL ".$e->getMessage());
				throw new Error("Erreur SQL ".$e->getMessage());
			}
			return $data;
		}

		/**
     	* Méthode d'insertion des données
     	*/
		public static function insert(array $data){
			// Vérification que le tableau contient ip
			if(!isset($data['ip'])){
				//die('ip manquante');
				throw new Error('ip manquante');
			}

			// Vérification que le tableau contient description
			if(!isset($data['description'])){
				//die('description manquante');
				throw new Error('description manquante');
			}

			// Instance PDO
			$pdo = \f3il\Database::getInstance();

			// Requête préparée SQL
			$req = $pdo->prepare("INSERT INTO formulaire (description,ip)".
			" VALUES(:description, :ip)");

			// Bind et envoit des données
			try{
				$req->bindValue(':description', $data['description']);
				$req->bindValue(':ip', $data['ip']);
				$req->execute();
			} catch(\PDOException $e){
				//die('Erreur SQL '.$e->getMessage());
				throw new Error('Erreur SQL '.$e->getMessage());
			}
			//return $data;
			return $pdo->lastInsertId();
		}

		/**
     	* Méthode de réception de l'Id
     	*/
		public static function get($id){
			// Instance de PDO
			$pdo = \f3il\Database::getInstance();
			// Requête préparée SQL
			$req = $pdo->prepare("SELECT * FROM formulaire WHERE id=:id");
			// Bind et envoit de la requête
			try{
				$req->bindValue(':id', $id);
				$req->execute();
				$data = $req->fetch(\PDO::FETCH_ASSOC);//PAS FETCH ALL
			} catch(\PDOException $e){
				//die('Erreur SQL '.$e->getMessage());
				throw new Error('Erreur SQL '.$e->getMessage());
			}
			return $data;
		}

		/**
     	* Modification des données
     	*/
		public static function update($data){
			if(!isset($data['id'])) {
				//die("Id manquant");
				throw new Error("Id manquant");
			}
			if(!isset($data['ip'])) {
				//die("Ip manquante");
				throw new Error("Ip manquante");
			}
			if(!isset($data['description'])) {
				//die("Description manquante");
				throw new Error("Description manquante");
			}

			// Instance de PDO
			$pdo = \f3il\Database::getInstance();
			// Requête préparée SQL
			$req = $pdo->prepare("UPDATE formulaire SET " .
				"description = :description,".
				"ip = :ip ".
				"WHERE id = :id"
			);

			// Bind et envoit de la requête
			try{
				$req->bindValue(':description', $data['description']);
				$req->bindValue(':ip', $data['ip']);
				$req->bindValue(':id', $data['id']);
				$req->execute();
			} catch(\PDOException $e){
				die('Erreur SQL '.$e->getMessage());
				throw new Error('Erreur SQL '.$e->getMessage());
			}
			return $pdo->lastInsertId();
		}
	}
