<?php

namespace Jules\Http;

class Curl
{
    private $info = null;
    private $usePost = false;
    private $url = '';
    private $userAgent = '';
    private $returnTransfer = false;
    private $postFields = array();
    private $error = null;
    private $verifyHost = false;
    private $verifyPeer = false;
    private $followLocation = true;
    private $header = false;
    private $maxRedirects = 10;
    private $autoReferer = true;
    private $timeout = 30;
    private $connectTimeout = 30;
    private $verbose = true;
    private $encoding = '';

    public function usePost($bool = true)
    {
        $this->usePost = $bool;
    }

    private function getUsePost()
    {
        return $this->usePost;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    private function getUrl()
    {
        return $this->url;
    }

    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;
    }

    private function getUserAgent()
    {
        return $this->userAgent;
    }

    private function setInfo($info)
    {
        $this->info = $info;
    }

    public function getInfo()
    {
        return $this->info;
    }

    public function setReturnTransfer($bool = true)
    {
        $this->returnTransfer = $bool;
    }

    private function getReturnTransfer()
    {
        return $this->returnTransfer;
    }

    public function setPostFields($array = array())
    {
        $this->postFields = $array;
    }

    private function getPostFields()
    {
        return $this->postFields;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setVerifyHost($bool = false)
    {
        $this->verifyHost = $bool;
    }

    private function getVerifyHost()
    {
        return $this->verifyHost;
    }

    public function setVerifyPeer($bool = false)
    {
        $this->verifyPeer = $bool;
    }

    private function getVerifyPeer()
    {
        return $this->verifyPeer;
    }

    public function setFollowLocation($bool = true)
    {
        $this->followLocation = $bool;
    }

    public function getFollowLocation()
    {
        return $this->followLocation;
    }

    public function useHeader($bool = false)
    {
        $this->header = $bool;
    }

    private function getHeader()
    {
        return $this->header;
    }

    public function setMaxRedirects($max = 10)
    {
        $this->maxRedirects = $max;
    }

    private function getMaxRedirects()
    {
        return $this->maxRedirects;
    }

    public function setAutoReferer($bool = true)
    {
        $this->autoReferer = $bool;
    }

    private function getAutoReferer()
    {
        return $this->autoReferer;
    }

    public function setTimeout($timeout = 30)
    {
        $this->timeout = $timeout;
    }

    private function getTimeout()
    {
        return $this->timeout;
    }

    public function setConnectTimeout($timeout = 30)
    {
        $this->connectTimeout = $timeout;
    }

    private function getConnectTimeout()
    {
        return $this->connectTimeout;
    }

    public function setVerbose($bool = true)
    {
        $this->verbose = $bool;
    }

    private function getVerbose()
    {
        return $this->verbose;
    }

    public function setEncoding($string)
    {
        $this->encoding = $string;
    }

    private function getEncoding()
    {
        return $this->encoding;
    }

    public function send()
    {
        if(function_exists('curl_init'))
        {
            $curl = curl_init($this->getUrl());

            curl_setopt_array($curl,
                array(
                    CURLOPT_RETURNTRANSFER => $this->getReturnTransfer(),
                    CURLOPT_USERAGENT => $this->getUserAgent(),
                    CURLOPT_POST => $this->getUsePost(),
                    CURLOPT_POSTFIELDS => $this->getPostFields(),
                    CURLOPT_SSL_VERIFYHOST => $this->getVerifyHost(),
                    CURLOPT_SSL_VERIFYPEER => $this->getVerifyPeer(),
                    CURLOPT_FOLLOWLOCATION => $this->getFollowLocation(),
                    CURLOPT_VERBOSE => $this->getVerbose(),
                    CURLOPT_HEADER => $this->getHeader(),
                    CURLOPT_MAXREDIRS => $this->getMaxRedirects(),
                    CURLOPT_AUTOREFERER => $this->getAutoReferer(),
                    CURLOPT_TIMEOUT => $this->getTimeout(),
                    CURLOPT_CONNECTTIMEOUT => $this->getConnectTimeout(),
                    CURLOPT_ENCODING => $this->getEncoding()
                )
            );

            $result = curl_exec($curl);

            $this->setInfo(curl_getinfo($curl));

            if(!$result)
            {
                $this->error = '['.curl_errno($curl).'] '.curl_error($curl);
            }

            curl_close($curl);

            return $result;
        }
        else
        {
            throw new \Exception('curl_init function is missing!');
        }
    }
}