<?php
/**
 * Created by PhpStorm.
 * User: oba
 * Date: 2016/3/13
 * Time: 2:04
 */






$url='http://p.sasa8.com/index.php?module=API&method=Live.getLastVisitsDetails&idSite=1&period=day&date=yesterday&format=JSON&token_auth=c38de7c5e14711949af48b11464d8cba';
/**
 * 不得使用 file_get_contents();
 */
$ch=curl_init($url);
curl_setopt($ch,CURLOPT_HEADER,0);
curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, 10); //默认等待10 超时
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
$json=curl_exec($ch);
echo $json;