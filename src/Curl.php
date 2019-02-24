<?php
namespace tan\curl;

class Curl{
	public static function request($url,$https=false,$post=false,$data=null){
	    //curl resource
        $ch=curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        //don't ssl
		if($https === true){
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
            curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        }
        if($post === true){
            curl_setopt($ch,CURLOPT_POST,true);
			
            if(!empty($data)){
                curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
            }
        }
        $result=curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}