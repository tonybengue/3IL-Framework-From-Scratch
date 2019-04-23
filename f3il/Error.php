<?php
namespace f3il;
defined('F3IL') or die('Accès Interdit');

class Error extends \Exception {
    protected $renderFile;

    public function __construct($message) {
        parent::__construct($message);
        $this->renderFIle = 'html/error.html.php';
    }

    public function render() {
        $app = Application::getInstance();
        $logger = $app->getLogger();
        $logger->addError($this->message, array(
            'file' => $this->getFile(),
            'line' =>$this->getLine()
        ));

        switch($app->getRunMode()) {
            case Application::DEBUG_MODE:
                $this->debugModeRender();
                break;
            case Application::PRODUCTION_MODE:
                $this->productionModeRender();
                break;
        }
    }

    private function productionModeRender() {
        //die(__METHOD__);
        Application::redirect('?controller=error');
    }

    private function debugModeRender() {
        //die(__METHOD__);
        $trace = $this->getTrace();
        $file = $this->getFile();
        $line = $this->getLine();
        $function = $trace[0]['function'].'()';
        include $this->renderFile();
        die();
    }
}
