<?php

namespace Jules\Http;

class Request
{
    public function get($string)
    {
        return $this->sanitize((isset($_GET[$string]) ? $_GET[$string] : false));
    }

    public function getPost($string)
    {
        return (isset($_POST[$string]) ? $_POST[$string] : false);
    }

    public function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST' ? true : false);
    }

    public function sanitize($string)
    {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

    public function isInt($string)
    {
        return filter_var($string, FILTER_VALIDATE_INT);
    }

    public function isValidIp($string)
    {
        return filter_var($string, FILTER_VALIDATE_IP);
    }

    public function isValidEmail($string)
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL);
    }
}