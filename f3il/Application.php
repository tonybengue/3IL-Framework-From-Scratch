<?php
namespace f3il;
defined('F3IL') or die('Accès Interdit');

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;

class Application {
    public const DEBUG_MODE = "debug";
    public const PRODUCTION_MODE = "production";

    private static $_instance = null;
    private $defaultControllerName = null;
    private $runMode = self::PRODUCTION_MODE;// mode prod par défaut
    private $logger = null;

    private function __construct() {
        $this->startLogger();
        $this->setRunMode();
    }

    private function startLogger() {
        $this->logger = new Logger('f3il');
        $this->logger->pushHandler(new StreamHandler('log/app.log'), Logger::DEBUG);
        $this->logger->addInfo('App started');
    }

    public function getLogger() {
        return $this->logger;
    }

    private function setRunMode() {
        $conf = Configuration::getInstance();
        if(isset($conf->run_mode) && $conf->run_mode == self::DEBUG_MODE) {
            $this->runMode == self::DEBUG_MODE;
            \error_reporting(E_ALL);
        } else {
            \error_reporting(0);
        }
    }

    public function getRunMode() {
        return $this->runMode;
    }

    public function runModeAction() {
       //die("runmode : ".f3il\Application::getInstance()->getRunMode);
    }

    /**
    *
    */
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new Application();
        }
        return self::$_instance;
    }

    /**
    * Nom du contrôller à passer
    */
    public function setDefaultControllerName($controllerName){
        $this->defaultControllerName = $controllerName;
    }

    /**
    * Obtient le namespace du Controller
    */
    public function getControllerClass($controllerName) {
        if($controllerName === "error") {
            return 'f3il\\ErrorController';
        }

        $controllerClass = APP_NAMESPACE.'\\Controllers\\'.$controllerName.'Controller';

        if(!class_exists($controllerClass)) {
           // die('Application : contrôleur introuvable '.$controllerClass);
           throw new Error('Application : contrôleur introuvable '.$controllerClass);
        }
        return $controllerClass;
    }

    /**
    * Lance l'initialisation
    */
    public function run() {
        try {
            // Récup dans GET du paramètre controller
            $controllerName = filter_input(INPUT_GET,'controller');

            // Si controller est null
            if(is_null($controllerName)) {
                if(is_null($this->defaultControllerName)) {
                    //die('Application : aucun contrôleur renseigné');
                    throw new Error('Application : aucun contrôleur renseigné');
                } else {
                    $controllerName = $this->defaultControllerName;
                }
            }

            // Génération du nom de la classe
            $controllerClass = $this->getControllerClass($controllerName);
            //echo $controllerClass;

            // Construction de l'objet contrôleur
            $controller = new $controllerClass();

            // Récupérer l'action à éxécuter
            $actionName = filter_input(INPUT_GET, 'action');
            // Action du controller à effectuer
            if(is_null($actionName)) {
                // die('Application : aucune action renseignée');
                $actionName = $controller->getDefaultActionName();
            }

            // Exécute action souhaitée
            $controller->execute($actionName);
            //var_dump($controller->execute($actionName));

            // Rendu de la page
            Page::getInstance()->render();
        } catch (Error $e) {
            $e->render();
        } catch (\Exception $e) {
            $this->logger->addError($e->getMessage());
            if($this->runMode == self::DEBUG_MODE) {
                throw $e;
            } else {
               // self::redirect('?controller=error');
            }
        }
    }
    /**
    * Si entêtes pas parties, possibles
    *    Sinon impossible
    */
    public static function redirect($url) {
        if(!headers_sent()) {
            header('HTTP/1.1 303 See Other');
            header('Location: '.$url);
            die();
        } else {
        ?>
            <script>
                window.location = '<?php echo $url; ?>';
            </script>
        <?php
        }
    }
}
