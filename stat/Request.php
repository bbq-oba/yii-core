<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2016/5/23
 * Time: 23:52
 */

namespace app\stat;

use app\stat\Intl\Data\Provider\RegionDataProvider;
use Piwik\Network\IP;
use yii\base\Exception;
use yii\base\Object;

class Request extends Object
{



    public function processVisit()
    {
        $request = \yii::$app->request;
        $params = [];

        $params['config_java'] = $request->get('java', 0);
        $params['config_pdf'] = $request->get('pdf', 0);
        $params['config_quicitime'] = $request->get('qt', 0);
        $params['config_realplayer'] = $request->get('realp', 0);
        $params['config_silverlight'] = $request->get('ag', 0);
        $params['config_windowsmedia'] = $request->get('wma', 0);
        $params['config_gears'] = $request->get('gears', 0);
        $params['config_flash'] = $request->get('fla', 0);
        $params['config_director'] = $request->get('dir', 0);
        $params['config_cookie'] = $request->get('cookie', 0);
        $params['lang'] = $request->get('lang', 0);
        $params['config_resolution'] = $this->getRes();

        $params['location_browser_lang'] = $this->getSingleLanguageFromAcceptedLanguages($params['lang']);

        $params['location_ip'] = $this->getIp();
        $params['idsite'] = $this->getIdSite();
        $params['idvisitor'] = $this->getVisitorId();
        $params['config_id'] = Settings::getConfigId($params['idsite'],$params['location_ip']);;




        $userAgent = $this->getUserAgent();
        $parser = DeviceDetectorFactory::getInstance($userAgent);
        $browserInfo = $parser->getClient();

        $params['config_browser_engine'] = $browserInfo['engine'];
        $params['config_browser_version'] = $browserInfo['version'];
        $params['config_browser_name'] = $browserInfo['short_name'];
        $params['config_device_brand'] = $parser->getBrand();
        $params['config_device_model'] = $parser->getModel();
        $params['config_device_type'] = $parser->getDevice();


        if ($parser->isBot()) {
            $os = Settings::OS_BOT;
        } else {
            $os = $parser->getOS();
            $os = empty($os['short_name']) ? 'UNK' : $os['short_name'];
        }
        $params['config_os'] = $os;
        $params['config_os_version'] = $parser->getOs('version');



        return $params;
    }

    /**
     * @param $vid int 主键
     * @return mixed
     */
    public function processVisitDetails($vid){
        $referrers = new Referrers();
        $information = $referrers->getReferrerInformationFromRequest();
        $params['referer_type'] = $information['referer_type'];
        $params['referer_name'] = $information['referer_name'];
        $params['referer_keyword'] = $information['referer_keyword'];
        $params['referer_url'] = $information['referer_url'];
        $params['current_url'] = $information['current_url'];
        $params['vid'] = $vid;
        return $params;
    }









    public static function getPlugins()
    {
        static $pluginsInOrder = array('fla', 'java', 'dir', 'qt', 'realp', 'pdf', 'wma', 'gears', 'ag', 'cookie');
        $plugins = array();
        foreach ($pluginsInOrder as $param) {
            $plugins[] = \yii::$app->request->get($param, 0);
        }
        return $plugins;
    }

    /**
     * Returns the ID from  the request in this order:
     * return from a given User ID,
     * or from a Tracking API forced Visitor ID,
     * or from a Visitor ID from 3rd party (optional) cookies,
     * or from a given Visitor Id from 1st party?
     *
     * @throws Exception
     */
    public function getVisitorId()
    {
        // If a third party cookie was not found, we default to the first party cookie
        $idVisitor = \yii::$app->request->get('_id');
        $found = strlen($idVisitor) >= Tracker::LENGTH_HEX_ID_STRING;

        if ($found) {
            $truncated = $this->truncateIdAsVisitorId($idVisitor);
            if (!empty($truncated)) {
                return $truncated;
            }
        }

        return false;
    }

    /**
     * @param $idVisitor
     * @return string
     */
    private function truncateIdAsVisitorId($idVisitor)
    {
        return substr($idVisitor, 0, Tracker::LENGTH_HEX_ID_STRING);
    }



    public $idSiteCache;

    public function getIdSite()
    {
        if (isset($this->idSiteCache)) {
            return $this->idSiteCache;
        }
        $idSite = \yii::$app->request->get('idsite', 0);

        if ($idSite <= 0) {
            throw new Exception('Invalid idSite: \'' . $idSite . '\'');
        }
        $this->idSiteCache = $idSite;
        return $idSite;
    }


    public static function getIp()
    {
        return self::getIpString();
    }

    /**
     * @return mixed|string
     * @throws Exception
     */
    public static function getIpString()
    {
        $cip = \yii::$app->request->get('cip');
        if (empty($cip)) {
            return \app\stat\IP::getIpFromHeader();
        }
        return $cip;
    }


    public static function getUserAgent()
    {
        $default = false;
        if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            $default = $_SERVER['HTTP_USER_AGENT'];
        }
        return \yii::$app->request->get('ua', $default);
    }


    public function getRes()
    {
        $resolution = \yii::$app->request->get('res');
        if (!empty($resolution)) {
            return substr($resolution, 0, 9);
        }
        return $resolution;
    }


    /**
     * For better privacy we store only the main language code, instead of the whole browser language string.
     *
     * @param $acceptLanguagesString
     * @return string
     */
    protected function getSingleLanguageFromAcceptedLanguages($acceptLanguagesString)
    {
        if (empty($acceptLanguagesString)) {
            return '';
        }
        $languageCode = Common::extractLanguageAndRegionCodeFromBrowserLanguage($acceptLanguagesString);
        return $languageCode;
    }


}