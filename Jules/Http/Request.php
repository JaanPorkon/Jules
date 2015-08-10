<?php

namespace Jules\Http;

class Request
{
    public function get($string = null)
    {
        return ($string == null ? $_GET : (isset($_GET[$string]) ? $this->sanitize($_GET[$string]) : false));
    }

    public function getPost($string = null)
    {
        return ($string == null ? $_POST : (isset($_POST[$string]) ? $this->sanitize($_POST[$string]) : false));
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