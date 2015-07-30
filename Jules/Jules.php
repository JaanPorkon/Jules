<?php

namespace Jules;

class Loader
{
    private $dirs = array();

    public function registerDirs($dirs = array())
    {
        $this->dirs = $dirs;
    }

    public function getDirs()
    {
        return $this->dirs;
    }
}
