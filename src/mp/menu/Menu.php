<?php

/*
 * This file is part of the kail520/yii2-wx
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace kail520\wx\mp\menu;

use kail520\wx\core\Driver;
use kail520\wx\core\AccessToken;
use yii\helpers\VarDumper;
use yii\httpclient\Client;
use kail520\wx\core\Exception;

/**
 * Menu
 * 微信公众号菜单助手
 *
 */
class Menu extends Driver {

    private $accessToken;

    const API_MENU_GET_URL = 'https://api.weixin.qq.com/cgi-bin/menu/get';
    const API_MENU_CREATE_URL = 'https://api.weixin.qq.com/cgi-bin/menu/create';

    public function init(){
        parent::init();
        $this->accessToken = (new AccessToken(['conf'=>$this->conf,'httpClient'=>$this->httpClient]))->getToken();
    }

    /**
     * 获得当前菜单列表
     *
     * @throws Exception
     * @return mixed
     */
    public function ls(){
        $response = $this->get(self::API_MENU_GET_URL."?access_token=".$this->accessToken)->send();

        if($response->isOk == false){
            throw new Exception(self::ERROR_NO_RESPONSE);
        }

        $response->setFormat(Client::FORMAT_JSON);
        $data = $response->getData();
        if(isset($data['errcode']) && $data['errcode'] != 0){
            throw new Exception($data['errmsg'], $data['errcode']);
        }

        return $data;
    }

    /**
     * 生成菜单
     *
     * @throws Exception
     * @param $buttons array 菜单数据
     * @return boolean
     */
    public function create($buttons = []){
        $this->httpClient->formatters = ['uncodeJson'=>'kail520\wx\helpers\JsonFormatter'];
        $request = $this->post(self::API_MENU_CREATE_URL."?access_token=".$this->accessToken,$buttons)
            ->setFormat('uncodeJson');

        $response = $request->send();

        if($response->isOk == false){
            throw new Exception(self::ERROR_NO_RESPONSE);
        }

        $response->setFormat(Client::FORMAT_JSON);
        $data = $response->getData();
        if(isset($data['errcode']) && $data['errcode'] != 0){
            throw new Exception($data['errmsg'], $data['errcode']);
        }

        return true;
    }
}