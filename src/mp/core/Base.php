<?php

/*
 * This file is part of the kail520/yii2-wx
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace kail520\wx\mp\core;

use kail520\wx\core\AccessToken;
use kail520\wx\core\Exception;
use kail520\wx\core\Driver;

/**
 * Base
 * 这里呈现一些基础的内容
 *
 */
class Base extends Driver {

    const API_BASE_IP_URL = "https://api.weixin.qq.com/cgi-bin/getcallbackip";

    /**
     * 获取微信服务器IP或IP段
     */
    public function getValidIps(){
        $access = new AccessToken(['conf'=>$this->conf,'httpClient'=>$this->httpClient]);
        $accessToken = $access->getToken();

        $response = $this->get(self::API_BASE_IP_URL,['access_token'=>$accessToken])->send();

        $data = $response->getData();
        if(isset($data["ip_list"]) == false){
            throw new Exception($data['errmsg'],$data['errcode']);
        }

        return $data['ip_list'];
    }
}