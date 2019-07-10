<?php
/*
 * This file is part of the kail520/yii2-wx
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace kail520\wx\mini\payment;

use kail520\wx\core\Exception;
use kail520\wx\helpers\Util;

/**
 * Notify API.
 */
class Notify {

    /**
     * @var $notify
     */
    protected $notify;

    /**
     * @var
     */
    protected $merchant;

    /**
     * @var boolean | array
     */
    protected $data = false;

    public function __construct($merchant){
        $this->merchant = $merchant;
    }

    public function getData(){
        if($this->data){
            return $this->data;
        }

        $xml = @$GLOBALS['HTTP_RAW_POST_DATA'];
        if(!$xml){
        	$xml = file_get_contents("php://input");
        }
        $xmlArray = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        return $this->data = $xmlArray;
    }

    /**
     * 检测签名
     */
    public function checkSign(){
        if($this->data == false){
            $this->getData();
        }

        $sign = Util::makeSign($this->data,$this->merchant['key']);
        if($this->GetSign() == $sign){
            return true;
        }
        throw new Exception("签名错误！");
    }

    public function GetSign(){
        return $this->data['sign'];
    }

}