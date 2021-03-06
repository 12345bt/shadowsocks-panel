<?php
/**
 * Project: shadowsocks-panel
 * Author: Sendya <18x@loacg.com>
 * Time: 2016/3/23 22:14
 */


namespace Controller;

use Helper\Util;

class Api {

    public function QueryCountry(){
        $ipAddress = Util::GetUserIP();
        $ch = curl_init();
        $url = 'http://apis.baidu.com/apistore/iplookupservice/iplookup?ip='.$ipAddress;
        $header = array(
            'apikey: 8c2732c8237d220bb1a281aa6f9ea7ea',
        );
        // 添加apikey到header
        curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 执行HTTP请求
        curl_setopt($ch , CURLOPT_URL , $url);
        $res = curl_exec($ch);
        echo $res;
        exit();
    }
}