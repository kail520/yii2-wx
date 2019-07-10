<?php
/*
 * This file is part of the kail520/yii2-wx
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace kail520\wx\mp\qrcode;

use kail520\wx\core\Driver;
use kail520\wx\core\AccessToken;
use yii\httpclient\Client;

/**
 * 长链接转短地址助手
 */
class Shorturl extends Driver {

    private $accessToken;

    const API_SHORT_URL = 'https://api.weixin.qq.com/cgi-bin/shorturl';

    public function init(){
        parent::init();
        $this->accessToken = (new AccessToken(['conf'=>$this->conf,'httpClient'=>$this->httpClient]))->getToken();
    }

    /**
     * 将一个微信支付的长连接转化为短链接
     * @param string $longUrl 长连接
     * @return string
     */
    public function toShort($longUrl = ''){
        $response = $this->post(self::API_SHORT_URL."?access_token=".$this->accessToken,['action'=>'long2short','long_url'=>$longUrl])->setFormat(Client::FORMAT_JSON)->send();

        $data = $response->getData();
        return $data['short_url'];
    }

}