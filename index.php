<?php
	require_once 'f3il/f3il.php';

	// Configuration ini
	f3il\Configuration::setConfigurationFile('application/configuration.ini');
	// $conf = f3il\Configuration::getInstance();

	//Constantes
	define('APP_FOLDER', 'application'); // Données de l'application
	define('TEMPLATE_FOLDER', APP_FOLDER.'/templates'); // templates
	define('VIEW_FOLDER', APP_FOLDER.'/views'); // dossier vues
	define('APP_NAMESPACE', 'app'); // namespace

	/*
		Model
			$insert = app\models\MaterielsModel::insert(array('description'=>'John DOE','ip'=>'127.0.0.1'));
			$db = app\models\MaterielsModel::getAll();
	*/

	//$page = \f3il\Page::getInstance();
	//$page->init('simple', 'test');
	//echo "OK";
	//$page->materiels = \app\models\MaterielsModel::getAll();
	//$page->render();

	/*echo 'Nouvelle tuple ajoutée ayant pour clé primaire "'.$insert.'"';
	echo '<pre>';
	print_r($db);
	echo '</pre>';*/

	/*
		$controller = new \app\controllers\MaterielsController();
		$controller->execute('test');
	*/

	// Instance de l'application
	$app = f3il\Application::getInstance();
	// Définit le contrôller
	$app->setDefaultControllerName('Materiels');
	// Lance l'application
	$app->run();

	//var_dump($app);
	//http://127.0.0.1:8001/bachelor/TD/Cours%20-%20TODO/?action=ajouter
?>
