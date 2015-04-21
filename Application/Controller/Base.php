<?php

namespace Application\Controller;

use Application\Component\DB;

class Base {

    protected $content;
    protected $layout;
    /**
     * @var DB
     */
    protected $db;
    protected $vars = [];

    public function __construct(DB $db)
    {
        $this->layout = 'layout';
        $this->title = '';
        $this->db = $db;
    }

    protected function render($pattern)
    {
        $content = $this->renderPattern($pattern);
        $this->setContent($content);
        echo $this->renderPattern($this->layout);
    }

    protected function renderPattern($pattern)
    {
        $patternFile = realpath(__DIR__ . "/../View/" . $pattern . ".php");
        if (file_exists($patternFile)) {
            ob_start();
            include $patternFile;
            return ob_get_clean();
        } else {
            throw new \Exception("$pattern not found!");
        }
    }

    protected function getContent()
    {
        return $this->content;
    }

    protected function setContent($content)
    {
        $this->content = $content;
    }

    protected function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * Return param request
     * @param $name
     * @return string
     */
    protected function param($name)
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST[$name])) {
            return addslashes($_POST[$name]);
        } elseif(isset($_GET[$name])) {
            return addslashes($_GET[$name]);
        }
    }

    protected function setVar($name, $value)
    {
        $this->vars[$name] = $value;
    }

    protected function getVar($name)
    {
        return isset($this->vars[$name]) ? $this->vars[$name] : null;
    }
    
}