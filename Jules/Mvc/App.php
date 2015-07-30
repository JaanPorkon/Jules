<?php

namespace Jules\Mvc;

class App
{
    private $dirs = null;

    public function __construct($loader = null)
    {
        if(is_null($loader))
        {
            throw new \Exception('Loader not loaded!');
        }
        else
        {
            $this->dirs = $loader->getDirs();
        }
    }

    private function getUrl()
    {
        if(isset($_GET['_url']))
        {
            return $_GET['_url'];
        }
        else
        {
            return '/index/index';
        }
    }

    public function getDirs()
    {
        return $this->dirs;
    }

    public function run()
    {
        $controller = new \Jules\Mvc\Controller($this->getUrl(), $this);
        $controller->Jules_LoadController();
    }
}