<?php
namespace f3il\Helpers;

defined('F3IL') or die ('Accès interdit');

abstract class CsrfHelper {
    const SESSION_KEY = 'f3il.csrfToken';

    /**
     * Génère le Token
     */
    public static function getToken(){
        if(!isset($_SESSION[self::SESSION_KEY])) {
            $_SESSION[self::SESSION_KEY] = hash('sha256', uniqid());
        }
        return $_SESSION[self::SESSION_KEY];
    }

    /**
     * Insérer dans le code HTML le champs caché
     */
    public static function csrf(){
        $token = self::getToken();
        ?>
        <input type="hidden" name="<?php echo $token; ?>" value="0">
        <?php
    }

    /**
     * Vérifie la présence du token dans les données reçues
     */
    public static function checkToken(){
        if(!isset($_SESSION[self::SESSION_KEY])) return false;
        $key = filter_input(INPUT_POST, $_SESSION[self::SESSION_KEY]);
        return $key === '0';
    }
}
