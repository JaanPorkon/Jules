<?php

namespace Jules\Mvc\Http;

class Request
{
    public function get($string)
    {
        return (isset($_GET[$string]) ? $_GET[$string] : false);
    }

    public function getPost($string)
    {
        return (isset($_POST[$string]) ? $_POST[$string] : false);
    }

    public function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
    }
}