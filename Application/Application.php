<?php

namespace Application;

use Application\Component\DB;

class Application {

    protected $action, $controller, $config;

    public function __construct($configFile)
    {
        spl_autoload_register(array('Application\Application', 'autoload'));
        $this->config = require_once($configFile);
        $this->action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';
        $db = new DB($this->config['db']);
        $this->controller = new Controller\Login($db);
    }

    public function run()
    {
        $method = $this->action . "Action";
        if (method_exists($this->controller, $method)) {
            try {
                $this->controller->$method();
            } catch (\Exception $e) {
                echo "Error! " . $e->getMessage();
            }
        } else {
            echo "Error! Action $this->action not exists!";
        }
    }

    public static function autoload($class)
    {
        $class = str_replace('Application\\', '', $class);
        $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
        if (file_exists($path)) {
            include_once $path;
            return;
        }
    }

}