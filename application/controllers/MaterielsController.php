<?php
namespace app\controllers;

defined('F3IL') or die('Acces Interdit');

// Utilise les classes
use app\models\MaterielsModel;
use f3il\Application;
use f3il\Page;

class MaterielsController extends \f3il\Controller {
    /**
     * Vue à afficher par féfaut
     */
    public function getDefaultActionName() {
        return 'lister';
    }

    /**
     * Permet d'appeler le template et la vue souhaitée
     */
    public function listerAction() {
        $page = \f3il\Page::getInstance();
        $page->init('simple', 'test');
        $page->materiels = MaterielsModel::getAll();
    }

    /**
     * Acces à la page action et permet l'ajout grâce à un formulaire
     */
    public function ajouterAction() {
        // Réglage de base
        $page = \f3il\Page::getInstance();
        $page->init('simple', 'materiel-form');
        $page->description = "";
        $page->ip = "";

        // Si le formulaire n'est pas envoyé
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;// effectuer le rendu
        }

        // Validation du token CSRF
        if(!\f3il\Helpers\CsrfHelper::checkToken()) {
            $page->_formMessage = "Echec de l'envoi de données";
            return;
        }

        if(!$this->validate()) return;

        // Sauvegarde /Insère les données dans MaterielsModel
        MaterielsModel::insert([
            "description" => $page->description,
            "ip" => trim($page->ip)
        ]);

        // Message de confirmation
        \f3il\Messenger::setMessage("Le matériel a bien été crée");

        // Redirection
        \f3il\Application::redirect('?controller=materiels&action=lister');

        //echo 'pre'.print_r($_POST, true).'<pre>';
        //die('Formulaire OK');
    }

    /**
     * Acces page de modification
     */
    public function modifierAction(){
        // Réglage de la page
        $page = \f3il\Page::getInstance();
        $page->init('simple', 'materiel-form');

        // Récupération de l'id du matériel à modifier, Validation en tant que int
        $page->id = filter_input(INPUT_GET, 'id');
        if(!isset($page->id) || !filter_var($page->id, FILTER_VALIDATE_INT)) {
            \f3il\Application::redirect('?controller=materiels&action=lister');
        }

        // Si pas POST
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $materiel = \app\Models\MaterielsModel::get($page->id);
            //var_dump($materiel);

            // Si le matériel demandé n'existe pas en base
           if(empty($materiel)) {
               \f3il\Application::redirect('?controller=materiels&action=lister');
           }
            // Chargement des données dans le formulaire
            $page->description = $materiel['description'];
            $page->ip = $materiel['ip'];

            return;
        }

        // Récupération et Validation
        if(!$this->validate()) return;

        \app\models\MaterielsModel::update([
            "description" => $page->description,
            "ip" => trim($page->ip),
            "id" => $page->id,
        ]);

       // echo'<pre>';
       // print_r(MaterielsModel::get(10));
        //die();

        // Message de confirmation
        \f3il\Messenger::setMessage("Le matériel a bien été modifié");

        // Redirection
        \f3il\Application::redirect('?controller=materiels&action=lister');
    }

    /**
     * Suppression
     */
    public function supprimerAction(){
        // Si pas POST
        if($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $materiel = \app\Models\MaterielsModel::get($page->id);

            // Si le matériel demandé n'existe pas en base
            if(empty($materiel)) {
                \f3il\Application::redirect('?controller=materiels&action=lister');
            }

            return;
        }

         // Message de confirmation
         \f3il\Messenger::setMessage("Le matériel a bien été modifié");

         // Redirection
         \f3il\Application::redirect('?controller=materiels&action=lister');
    }

    private function validate() {
        $page = \f3il\Page::getInstance();
        // Récupération des données
        $page->description = filter_input(INPUT_POST,'description');
        if(trim($page->description) === "") {
            $page->_formMessage = "Veuillez fournir une description";
            return false;
        }

         // Filtre l'adresse IP
         $page->ip = filter_input(INPUT_POST, 'ip');
         if(!filter_var(trim($page->ip), FILTER_VALIDATE_IP)) {
             $page->_formMessage = "Erreur : veuillez fournir une adresse IP valide";
             return false;
         }
         return true;
    }

   /* public function runModeAction() {
        throw new \f3il\Error("Demo de l'erreur");
        //throw new \InvalidArgumentException("Demo de l'erreur");
    }*/
}
