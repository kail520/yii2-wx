<?php
/*
 * This file is part of the kail520/yii2-wx.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace kail520\wx\core;

/**
 * Exception
 * yii2-wx专属异常类
 */
class Exception extends \yii\base\Exception {

    public function getName(){
        return '微信SDK（kail520/yii2-wx）';
    }

}
