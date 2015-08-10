<?php

namespace Jules\Util;

class Url
{
    private $data = array();
    private $host = null;
    private $scheme = null;
    private $port = null;
    private $user = null;
    private $pass = null;
    private $path = null;
    private $query = null;
    private $fragment = null;

    private $baseUri = null;

    public function __construct($url = null)
    {
        if(!is_null($url))
        {
            if(substr($url, 0, 2) == '//')
            {
                $url = 'https:'.$url;
            }
            elseif(substr($url, 0, 1) == '/')
            {

            }

            $this->data = parse_url($url);

        }
        else
        {
            $this->data = parse_url($this->toString());
        }

        $this->parseVars();
    }

    private function parseVars()
    {
        $this->host = @$this->data['host'];
        $this->scheme = @$this->data['scheme'];
        $this->port = @$this->data['port'];
        $this->user = @$this->data['user'];
        $this->pass = @$this->data['pass'];
        $this->path = @$this->data['path'];
        $this->query = @$this->data['query'];
        $this->fragment = @$this->data['fragment'];
    }

    public function setBaseUri($string)
    {
        return $this->baseUri = $string;
    }

    public function getBaseUri()
    {
        return $this->baseUri;
    }

    private function isFullUrl($string)
    {
        if(substr($string, 0, 2) == '//')
        {
            $string = 'https:'.$string;
        }

        $parseUrl = parse_url($string);

        if(isset($parseUrl['scheme']) && isset($parseUrl['host']) && isset($parseUrl['path']))
        {
            return true;
        }
        else
        {
            false;
        }
    }

    public function buildUrl($string)
    {
        if($this->isFullUrl($string))
        {
            return $string;
        }
        else
        {
            return $this->getScheme().'://'.str_replace('//', '/', $this->getHost().$this->getPort().$this->getBaseUri().$string);
        }
    }

    public function getHost()
    {
        if(is_null($this->host))
        {
            return $_SERVER['SERVER_NAME'];
        }
        else
        {
            return $this->host;
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getQuery()
    {
        if(is_null($this->query))
        {
            $requestUri = $_SERVER['REQUEST_URI'];

            return substr($requestUri, strpos('?', $requestUri), (strpos('#', $requestUri) == -1 ? strlen($requestUri) : strpos('#', $requestUri)));
        }
        else
        {
            return $this->query;
        }
    }

    public function getQueryTable()
    {
        $query = $this->getQuery();
        $data = array();

        foreach(explode('&', $query) as $params)
        {
            foreach(explode('=', $params) as $key => $val)
            {
                $data[$key] = $val;
            }
        }

        return $data;
    }

    public function getScheme()
    {
        if(is_null($this->scheme))
        {
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            {
                return 'https';
            }
            else
            {
                return 'http';
            }
        }
        else
        {
            return $this->scheme;
        }
    }

    public function getPort()
    {
        if(is_null($this->port))
        {
            if(isset($_SERVER['SERVER_PORT']))
            {
                return ':'.$_SERVER['SERVER_PORT'];
            }
            else
            {
                return ':80';
            }
        }
        else
        {
            return ':'.$this->port;
        }
    }

    public function getUsername()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->pass;
    }

    public function getFragment()
    {
        return $this->fragment;
    }

    public function isSecure()
    {
        return ($this->getScheme() == 'https' ? true : false);
    }

    public function getData()
    {
        return $this->data;
    }

    public function toString()
    {
        return $this->getScheme().'://'.$this->getHost().$this->getPath().$this->getQuery();
    }
}