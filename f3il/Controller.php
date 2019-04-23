<?php
namespace f3il;
defined('F3IL') or die('Accès Interdit');

abstract class Controller {
    public function getDefaultActionName() {
        die('Controller : aucune action par défaut n\'a été définie pour la classe '
        .get_class($this));
    }

    public function execute($actionName) {
        $actionMethod = $actionName.'Action';
        if(!method_exists($this, $actionMethod)) {
            die("Controller : action non disponible ".$actionName. " pour le contrôleur ".
            get_class($this));
        }
        $this->$actionMethod();
    }
}
