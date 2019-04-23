<?php
namespace f3il;
defined('F3IL') or die('Accès Interdit');

abstract class Messenger {
    const SESSION_KEY = "f3il.messenger";

    public static function setMessage($message) {
        $_SESSION[self::SESSION_KEY] = $message;
    }

    public static function getMessage() {
        if(!isset($_SESSION[self::SESSION_KEY])) return false;
        $message = $_SESSION[self::SESSION_KEY];

        unset($_SESSION[self::SESSION_KEY]);
        return $message;
    }
}
