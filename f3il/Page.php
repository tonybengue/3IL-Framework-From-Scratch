<?php
namespace f3il;
defined('F3IL') or die('Accès Interdit');

// file_exists : si fichier existe
// is readbale

// Singleton
class Page {
    private static $_instance = null;
    protected $viewFile = null;
    protected $templateFile = null;

    protected $data = [];
    private function __construct() {}

    /**
     * Création de l'instance
     */
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new Page;
        }
        return self::$_instance;
    }

    /**
     * Configuration des vues
     */
    public function setView($view) {
        // Chemin
        $viewFile = VIEW_FOLDER.'/'.$view.'.view.php';

        // Si pas lisible
        if(!is_readable($viewFile)) {
            die("Page : fichier de view introuvable" .$viewFile);
        }
        $this->viewFile = $viewFile;
        return $this;
    }

    /**
     * Configuration des templates
     */
    public function setTemplate($template) {
        // Chemin
        $templateFile = TEMPLATE_FOLDER.'/'.$template.'.template.php';

        // Si pas lisible
        if(!is_readable($templateFile)) {
            die("Page : fichier de view introuvable '.$templateFile");
        }
        $this->templateFile = $templateFile;
        return $this;
    }

    /**
     * @string $template Template à recevoir lors de l'initialisation
     *
     * Initilialisation
     */
    public function init($template, $view) {
        $this->setTemplate($template)->setView($view);
    }

    /**
     * Rendu
     */
    public function render() {
        if(is_null($this->templateFile)) {
            die('Page : aucun template renseigné');
        }
        require $this->templateFile;
    }

    /**
     * Insertion de la vue
     */
    public function insertView() {
        if(is_null($this->viewFile)) {
            die('Page : aucune view renseignée');
        }
        require $this->viewFile;
    }

    /**
     * Variable magique
     */
    public function __get($item) {
        if(!isset($this->data[$item])) {
            die('Page : Donnée introuvable '.$item);
        }
        return $this->data[$item];
    }

    /**
     * Variable magique
     */
    public function __set($item, $value) {
        $this->data[$item] = $value;
    }

    /**
     * Variable magique
     */
    public function __isset($item) {
        return isset($this->data[$item]);
    }

    /**
     * Variable magique
     */
    public static function insertModule($module) {
        $moduleClass = APP_NAMESPACE.'\\modules\\'.$module;

        if (!\class_exists($moduleClass)) {
            die('Page : Aucune classe ne correspond au module '.$module);
        }

        $interfaces = \class_implements($moduleClass);
        if(!isset($interfaces['f3il\Module'])) {
            die('Page : La classe '.$module.' ne respecte pas l\'interface Module');
        }

        $objModule = new $moduleClass();
        $objModule->render();
    }
}
