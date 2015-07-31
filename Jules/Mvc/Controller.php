<?php

namespace Jules\Mvc;

class Controller
{
    private $__JulesClass = null;
    private $__JulesMethod = null;

    private $__JulesControllerDir = null;

    public $view = null;
    public $tag = null;
    public $response = null;
    public $request = null;

    public function __construct($path = null, $loader = null)
    {
        $this->request = new \Jules\Http\Request();
        $this->response = new \Jules\Http\Response();
        $this->tag = new \Jules\Mvc\Tag();


        if(!is_subclass_of(get_called_class(), 'Jules\Mvc\Controller'))
        {
            $controllerDir = null;

            if(!is_null($loader))
            {
                $dirs = $loader->getDirs();
                $controllerDir = $dirs['controllers'];
            }

            $this->view = new \Jules\Mvc\Views($this, $loader, $this->tag);

            if(is_null($controllerDir))
            {
                throw new \Exception('Controller directory missing!');
            }
            else
            {
                $this->Jules_SetDir($controllerDir);
            }

            if(is_null($path))
            {
                $this->Jules_SetClass('IndexController');
                $this->Jules_SetMethod('indexAction');
            }
            else
            {
                $route = explode('/', substr($path, 1, strlen($path)));

                $this->Jules_SetClass($route[0].'Controller');

                if(count($route) >= 2)
                {
                    $this->Jules_SetMethod($route[1].'Action');
                }
                else
                {
                    $this->Jules_SetMethod('indexAction');
                }
            }
        }
        else
        {
            $route = explode('/', substr($path, 1, strlen($path)));

            $this->Jules_SetClass($route[0].'Controller');
            $this->Jules_SetMethod('onConstruct');
        }
    }

    private function Jules_LoadClassFile()
    {
        if(file_exists($this->Jules_GetDir().$this->Jules_GetClass().'.php'))
        {
            require_once($this->Jules_GetDir().$this->Jules_GetClass().'.php');
        }
        else
        {
            throw new \Exception($this->Jules_GetClass().' file does not exist!');
        }
    }

    public function Jules_LoadController()
    {
        $this->Jules_LoadClassFile();

        $className = $this->Jules_GetClass();
        $class = new $className;
        $class->tag = $this->tag;

        ob_start();

        $initFunction = 'initialize';

        if(is_callable(array($class, $initFunction), false, $initFunction))
        {
            $class->initialize();
        }

        call_user_func_array(array($class, $this->Jules_GetMethod()), $this->Jules_GetMethodParams($class, $this->Jules_GetMethod()));

        $cachedResult = ob_get_contents();

        ob_end_clean();

        $this->view->setContent($cachedResult);

        echo $this->view->render();
    }

    /**
     * Helpers
     */

    public function Jules_GetMethodParams(&$class, $method)
    {
        $classReflector = new \ReflectionClass($class);
        $classParams = $classReflector->getMethod($method)->getParameters();
        $classParamValues = array();

        foreach($classParams as $obj)
        {
            $classParamValues[] = $this->request->get($obj->name);
        }

        return $classParamValues;
    }

    public function Jules_SetDir($dir)
    {
        $this->__JulesControllerDir = $dir;
    }

    private function Jules_GetDir()
    {
        return $this->__JulesControllerDir;
    }

    public function Jules_SetClass($class)
    {
        $this->__JulesClass = $class;
    }

    private function Jules_SetMethod($method)
    {
        $this->__JulesMethod = $method;
    }

    public function Jules_GetClass()
    {
        return $this->__JulesClass;
    }

    public function Jules_GetMethod()
    {
        return $this->__JulesMethod;
    }
}