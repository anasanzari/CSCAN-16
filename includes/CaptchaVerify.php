<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CaptchaVerify
 *
 * @author anasanzari
 */
class CaptchaVerify {

    public static function verify($response) {
        $url =  "https://www.google.com/recaptcha/api/siteverify";
        $data = array('secret' => '6LfwugwTAAAAAPgn64O1a1AqEcPRJDMBTKZKTfFj', 'response' => $response);
        $res = self::post($url,$data);
        $val = json_decode($res,TRUE);
        return $val["success"];
    }

    public static function post($url,$data) {
        //$url = 'http://server.com/path';
        //$data = array('key1' => 'value1', 'key2' => 'value2');
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

}
