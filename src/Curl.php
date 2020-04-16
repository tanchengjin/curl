<?php

namespace tan\curl;

class Curl
{
    private $ch;

    private $source;
    private $message;
    private $error_code;

    private $url=null;
    private $https=false;
    private $post=false;
    private $data=[];

    public function __construct($url=null, $https = false, $post = false, $data = [])
    {
        $this->url=$url;
        $this->https=$https;
        $this->post=$post;
        $this->data=$data;
        $this->init();
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->error_code;
    }

    protected function request($url, $https = false, $post = false, array $data = [])
    {
        $this->setUrl($url[0]);
        $this->https=$https;
        $this->post=$post;
        $this->data=$data;
        return $this->handler();
    }
    public function setUrl($url){
        $this->url=$url;
        return $this;
    }
    private function init(){
        if (is_null($this->ch) && !is_null($this->url)){
            $this->ch = curl_init($this->url);
        }
    }
    private function handler()
    {
        //curl resource
        $this->init();
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        //don't ssl
        if ($this->https === true) {
            $this->setHttps();
        }
        if ($this->post === true) {
            $this->setPost();
        }
        $this->source = curl_exec($this->ch);
        $this->error_code = curl_errno($this->ch);
        $this->message = curl_error($this->ch);

        curl_close($this->ch);
        return $this->getResult();
    }

    public function setHttps($peer = false, $host = false)
    {
        #verify local
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, $peer);
        #verify server
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, $host);
        return $this;
    }

    public function setPost()
    {
        curl_setopt($this->ch, CURLOPT_POST, true);

        if (!empty($this->data)) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $this->data);
        }
        return $this;
    }

    public function post($url=null,array $data=[])
    {
        $this->setUrl($url);
        if(!empty($data)){
            $this->data=$data;
        }
        $this->post=true;
        $this->handler();
        return $this->getResult();
    }
    public function get($url=null){
        $this->setUrl($url);
        $this->handler();
        return $this->getResult();
    }
    private function getResult()
    {
        return [
            'source' => $this->source,
            'error_code' => $this->error_code,
            'message' => $this->message,
        ];
    }


    public static function __callStatic($func, $args)
    {
        return (new static)->$func($args);
    }
}