<?php

/*
 * This file is part of the kail520/yii2-wx.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace kail520\wx\helpers;

/**
 * 自定义的json数据formatter
 * 该formatter主要是在数据进行json_encode时对其中的汉字内容不进行编码
 *
 */
class JsonFormatter extends \yii\httpclient\JsonFormatter {

    public $encodeOptions = 256;
}