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
use kail520\wx\helpers\Xml;
use yii\base\Component;

/**
 * Notify API.
 */
class Notify extends Component
{

    /**
     * 收到的通知（数组形式）
     * @var
     */
    protected $notify;

    public $merchant;

    protected $data = false;

    public function getData()
    {
        if ($this->data) {
            return $this->data;
        }

        return $this->data = Xml::parse(file_get_contents('php://input'));
    }

    public function checkSign()
    {
        if ($this->data == false) {
            $this->getData();
        }

        $sign = Util::makeSign($this->data, $this->merchant['key']);
        if ($sign != $this->data['sign']) {
            throw new Exception("签名错误！");
        }

        return true;
    }
}