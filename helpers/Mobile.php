<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/4/26
 * Time: 1:29
 */

namespace app\helpers;


class Mobile
{
    public static function check($mobile){
        return  preg_match('/^1[358]{1}[0-9]{1}[0-9]{8}$|^14[57]{1}[0-9]{8}$|^17[13678]{1}[0-9]{8}$|170[05789]{1}[0-9]{7}$/',$mobile);
    }

}