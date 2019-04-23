<?php
	namespace f3il;
	defined('F3IL') or die('Accès Interdit');

	require_once 'Configuration.php';

	class Database{
		private static $_pdo = null; // Unique instance de la classe

		/**
     	*
     	*/
		private function __construct(){
			$conf = Configuration::getInstance();
			if(!isset($conf->db_driver)){
				die('Database: Erreur db_driver non renseigné');
			}
			switch($conf->db_driver){
				case 'pdo_mysql':
					$this->makePDOMySQL($conf);
					break;
				case 'pdo_sqlite':
					$this->makePDOSQLite($conf);
					break;
				default:
					die('Database: db_driver non géré');
			}
			self::$_pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
			self::$_pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);
		}

		/**
     	*
     	*/
		public static function getInstance(){
			if(is_null(self::$_pdo)){
				new Database;
			}
			return self::$_pdo;
		}

		/**
     	*
     	*/
		public function makePDOMySQL(Configuration $conf){
			$expected = ['db_host','db_login','db_password','db_base'];

			foreach($expected as $field){
				if(!isset($conf->$field)){
					die('Database: '.$field.' n\'est pas présent dans la configuration');
				}
				try{
					self::$_pdo = new \PDO('mysql:host='.$conf->db_host.';dbname='.$conf->db_base.';charset=utf8',
					$conf->db_login,
					$conf->db_password);
				} catch(\PDOException $e) {
					die('Database: Erreur connexion '.$e->getMessage());
				}
			}
		}

		/**
     	*
     	*/
		public function makePDOSQLite(Configuration $conf){
			$expected = ['db_host','db_login','db_password','db_base'];
			if(!isset($conf->db_file)){
				die('Database: Nom du fichier SQLITE manquant');
			}
			try{
				self::$_pdo = new \PDO('sqlite:'.$conf->db_file);
			} catch(\PDOException $e) {
				die('Database: Ouverture du fichier SQLITE '.$e->getMessage());
			}
		}
	}
?>
