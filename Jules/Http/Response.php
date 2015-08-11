<?php

namespace Jules\Http;

class Response
{
    public function setStatusCode($code)
    {
        http_response_code((int)$code);
    }

    public function redirect($url)
    {
        global $Jules_url;

        header('Location: '.$Jules_url->buildUrl($url));
    }

    public function contentType($string)
    {
        header('Content-type: '.$string);
    }
}