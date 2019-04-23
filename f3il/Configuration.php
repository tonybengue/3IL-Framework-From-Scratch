<?php
	namespace f3il;
	defined('F3IL') or die('Accès Interdit');

	Class Configuration{
		private static $_instance = null; // Unique instance de la classe
		private static $_inifile = null; // Chemin du fichier INI
		private $data;

		/**
		 * Vérification du fichier .ini
		 */
		private function __construct(){
			if(is_null(self::$_inifile)){
				die('Fichier INI non renseigné');
			}
			if(!is_readable(self::$_inifile)){
				die('Fichier INI non lisible');
			}
			$this->data = parse_ini_file(self::$_inifile);
			if(!$this->data){
				die('Erreur dans la lecture du fichier INI');
			}
		}

		/**
		 *
		 */
		public static function setConfigurationFile($inifile){
			self::$_inifile = $inifile;
		}

		/**
		 *
		 */
		public static function getInstance(){
			if(is_null(self::$_instance)){
				self::$_instance = new Configuration();
			}
			return self::$_instance;
		}

		/**
		 *
		 */
		public function __get($item){
			if(!isset($this->data[$item])){
				die('Erreur clé INI inexistante');
			}
			return $this->data[$item];
		}

		/**
		 *
		 */
		public function __isset($item){
			return isset($this->data[$item]);
		}
	}
?>
