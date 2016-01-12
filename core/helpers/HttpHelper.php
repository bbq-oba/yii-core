<?php
/**
 * @author oba.ou
 */

/**
 * Http业务类
 * @author coso
 */
namespace app\core\helpers;

use yii\helpers\Json;
use yii\helpers\VarDumper;

class HttpHelper
{

    const TYPE_GET = 1;
    const TYPE_POST = 2;

    /**
     * 获取远程内容
     * @param string $url 远程链接
     * @param string|array $data 请求参数
     * @param int $timeout
     * @internal param int $second 超时
     * @return mixed
     */
    public static function get_remote_result($url, $data, $timeout = 3)
    {
        if (is_array($data)) {
            $url .= http_build_query($data);
        } else {
            $url .= $data;
        }
//        dd($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
//        $http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
        curl_close($ch);
        return $content;
    }

    /**
     * 以post形式发送数据$data到$url指定的网址
     */
    public static function httpPost($url, $data, $timeout = 30)
    {
        // if (is_array($data)) {
        // 	$data = http_build_query($data);
        // }
        // dd($url,$data);
        $ch = curl_init();
        //考虑 PHP 5.0~5.6 各版本兼容性的 cURL 文件上传
        //http://segmentfault.com/a/1190000000725185
        if (class_exists('CURLFile', false)) {
            curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        } else {
            if (defined('CURLOPT_SAFE_UPLOAD')) {
                curl_setopt($ch, CURLOPT_SAFE_UPLOAD, false);
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HEADER, 0);//返回数据不包含头信息
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);//刷新链接
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//POST提交的数据
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'TEST PHP5 Client 1.1 (curl) ' . phpversion());
        $result = curl_exec($ch);
//        $http_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
        $err = curl_error($ch);
        if (false === $result || !empty ($err)) {
            $errno = curl_errno($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);
            $data = Json::encode($data);
            $log = "get remote api error {$url}-{$data}-response code is {$errno} and result " . VarDumper::dumpAsString($info);
            \yii::error($log,'getremoteapi');
            return array(
                'result' => $result,
                'errno' => $errno,
                'msg' => $err,
                'info' => $info
            );
        }
        curl_close($ch);
        return $result;
    }

    public static function run($url, $data, $method = self::TYPE_GET, $timeout = 30)
    {
        if ($method == self::TYPE_GET) {
            return trim(self::get_remote_result($url, $data, $timeout));
        } else {
            return trim(self::httpPost($url, $data, $timeout));
        }
    }
}