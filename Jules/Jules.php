<?php

namespace Jules;

class Loader
{
    private $dirs = array();
    public $customFactory = array();

    public function registerDirs($dirs = array())
    {
        $this->dirs = $dirs;

        $this->loadModels($this->dirs['models']);
    }

    private function loadModels($modelsDir)
    {
        if($modelHandle = opendir($modelsDir))
        {
            while(($model = readdir($modelHandle)) !== false)
            {
                if($model != '.' && $model != '..')
                {
                    require_once($modelsDir.$model);
                }
            }
        }
    }

    public function getDirs()
    {
        return $this->dirs;
    }

    public function set($name, $function)
    {
        if($name == 'url')
        {
            global $Jules_url;

            $Jules_url = $function();
        }

        $this->customFactory[$name] = $function;
    }

    public function getCustomFactory()
    {
        return $this->customFactory;
    }
}
