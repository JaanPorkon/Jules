<?php

namespace Jules\Http;

class Response
{
    public function setStatusCode($code)
    {
        http_response_code((int)$code);
    }
}