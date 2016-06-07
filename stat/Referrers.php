<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace app\stat;



class Referrers
{

    // @see detect*() referrer methods
    public $typeReferrerAnalyzed;
    public $nameReferrerAnalyzed;
    public $keywordReferrerAnalyzed;
    public $referrerHost;
    public $referrerUrl;
    public $referrerUrlParse;
    public $currentUrlParse;
    public $idsite;

    private static $cachedReferrerSearchEngine = array();

    // Used to prefix when a adsense referrer is detected
    const LABEL_PREFIX_ADWORDS_KEYWORD = '(adwords) ';
    const LABEL_ADWORDS_NAME = 'AdWords';

    public $currentUrl;
    protected function getReferrerInformation()
    {

        // default values for the referer_* fields
        $referrerUrl = Common::unsanitizeInputValue($this->referrerUrl);
        if (!empty($referrerUrl)
            && !UrlHelper::isLookLikeUrl($referrerUrl)
        ) {
            $referrerUrl = '';
        }

        $currentUrl = PageUrl::cleanupUrl($this->currentUrl);




        $this->referrerUrl = $referrerUrl;
        $this->referrerUrlParse = @parse_url($this->referrerUrl);
        $this->currentUrlParse = @parse_url($currentUrl);
        $this->typeReferrerAnalyzed = Common::REFERRER_TYPE_DIRECT_ENTRY;
        $this->nameReferrerAnalyzed = '';
        $this->keywordReferrerAnalyzed = '';
        $this->referrerHost = '';

        if (isset($this->referrerUrlParse['host'])) {
            $this->referrerHost = $this->referrerUrlParse['host'];
        }


        $referrerDetected = $this->detectReferrerCampaign();
        if (!$referrerDetected) {
            if ($this->detectReferrerDirectEntry()
                || $this->detectReferrerSearchEngine()
            ) {
                $referrerDetected = true;
            }
        }

        if (!$referrerDetected && !empty($this->referrerHost)) {
            $this->typeReferrerAnalyzed = Common::REFERRER_TYPE_WEBSITE;
            $this->nameReferrerAnalyzed = Common::mb_strtolower($this->referrerHost);
            $urlsByHost = $this->getCachedUrlsByHostAndIdSite();

            $directEntry = new SiteUrls();
            $path = $directEntry->getPathMatchingUrl($this->referrerUrlParse, $urlsByHost);
            if (!empty($path) && $path !== '/') {
                $this->nameReferrerAnalyzed .= rtrim($path, '/');
            }
        }

        $referrerInformation = array(
            'referer_type'    => $this->typeReferrerAnalyzed,
            'referer_name'    => $this->nameReferrerAnalyzed,
            'referer_keyword' => $this->keywordReferrerAnalyzed,
            'referer_url'     => $this->referrerUrl,
            'current_url'     => $this->currentUrl
        );

        return $referrerInformation;
    }

    public function getReferrerInformationFromRequest()
    {
        $this->referrerUrl = \yii::$app->request->get('urlref');
        $this->currentUrl  = \yii::$app->request->get('url');




        if(preg_match('/[\x{10000}-\x{10FFFF}]/u', $this->referrerUrl)){
            $this->referrerUrl = preg_replace('/[\x{10000}-\x{10FFFF}]/u', "\xEF\xBF\xBD", $this->referrerUrl);
        }

        if(preg_match('/[\x{10000}-\x{10FFFF}]/u', $this->currentUrl)){
            $this->currentUrl = preg_replace('/[\x{10000}-\x{10FFFF}]/u', "\xEF\xBF\xBD", $this->currentUrl);
        }



        return $this->getReferrerInformation();
    }

    /**
     * Search engine detection
     * @return bool
     */
    protected function detectReferrerSearchEngine()
    {
        if (isset(self::$cachedReferrerSearchEngine[$this->referrerUrl])) {
            $searchEngineInformation = self::$cachedReferrerSearchEngine[$this->referrerUrl];
        } else {
            $searchEngineInformation = SearchEngine::getInstance()->extractInformationFromUrl($this->referrerUrl);
            self::$cachedReferrerSearchEngine[$this->referrerUrl] = $searchEngineInformation;
        }

        if ($searchEngineInformation === false) {
            return false;
        }

        $this->typeReferrerAnalyzed = Common::REFERRER_TYPE_SEARCH_ENGINE;
        $this->nameReferrerAnalyzed = $searchEngineInformation['name'];
        $this->keywordReferrerAnalyzed = $searchEngineInformation['keywords'];
        return true;
    }


    private function getCachedUrlsByHostAndIdSite()
    {
//        $cache = Cache::getCacheGeneral();


        $cache = [];

        if (!empty($cache['allUrlsByHostAndIdSite'])) {
            return $cache['allUrlsByHostAndIdSite'];
        }

        return array();
    }

    /**
     * We have previously tried to detect the campaign variables in the URL
     * so at this stage, if the referrer host is the current host,
     * or if the referrer host is any of the registered URL for this website,
     * it is considered a direct entry
     * @return bool
     */
    protected function detectReferrerDirectEntry()
    {
        if (empty($this->referrerHost)) {
            return false;
        }

        $urlsByHost = $this->getCachedUrlsByHostAndIdSite();
        $directEntry   = new SiteUrls();
        $matchingSites = $directEntry->getIdSitesMatchingUrl($this->referrerUrlParse, $urlsByHost);

        if (isset($matchingSites) && is_array($matchingSites) && in_array($this->idsite, $matchingSites)) {
            $this->typeReferrerAnalyzed = Common::REFERRER_TYPE_DIRECT_ENTRY;
            return true;
        } elseif (isset($matchingSites)) {
            return false;
        }

        // fallback logic if the referrer domain is not known to any site to not break BC
        if (isset($this->currentUrlParse['host'])) {
            // this might be actually buggy if first thing tracked is eg an outlink and referrer is from that site
            $currentHost = Common::mb_strtolower($this->currentUrlParse['host']);
            if ($currentHost == Common::mb_strtolower($this->referrerHost)) {
                $this->typeReferrerAnalyzed = Common::REFERRER_TYPE_DIRECT_ENTRY;
                return true;
            }
        }

        return false;
    }


    /**
     * @return bool
     */
    protected function detectReferrerCampaign()
    {
//        //false
//        $isCampaign = $this->detectReferrerCampaignFromTrackerParams();
//
//        if (!$isCampaign) {
//            $this->detectReferrerCampaignFromLandingUrl();//false
//        }
//
////        $this->detectCampaignKeywordFromReferrerUrl();


        $isCurrentVisitACampaignWithSameName = \yii::$app->request->get('referer_name') == $this->nameReferrerAnalyzed;


        $isCurrentVisitACampaignWithSameName = $isCurrentVisitACampaignWithSameName && \yii::$app->request->get('referer_type') == Common::REFERRER_TYPE_CAMPAIGN;

        // if we detected a campaign but there is still no keyword set, we set the keyword to the Referrer host
        if (empty($this->keywordReferrerAnalyzed)) {
            if ($isCurrentVisitACampaignWithSameName) {
                $this->keywordReferrerAnalyzed = \yii::$app->request->get('referer_keyword');
                // it is an existing visit and no referrer keyword was used initially (or a different host),
                // we do not use the default referrer host in this case as it would create a new visit. It would create
                // a new visit because initially the referrer keyword was not set (or from a different host) and now
                // we would set it suddenly. The changed keyword would be recognized as a campaign change and a new
                // visit would be forced. Why would it suddenly set a keyword but not do it initially?
                // This happens when on the first visit when the URL was opened directly (no referrer or different host)
                // and then the user navigates to another page where the referrer host becomes the own host
                // (referrer = own website) see https://github.com/piwik/piwik/issues/9299
            } else {
                $this->keywordReferrerAnalyzed = $this->referrerHost;
            }
        }

        if ($this->typeReferrerAnalyzed != Common::REFERRER_TYPE_CAMPAIGN) {
            $this->keywordReferrerAnalyzed = null;
            $this->nameReferrerAnalyzed = null;
            return false;
        }

        $this->keywordReferrerAnalyzed = Common::mb_strtolower($this->keywordReferrerAnalyzed);
        $this->nameReferrerAnalyzed = Common::mb_strtolower($this->nameReferrerAnalyzed);
        return true;
    }


}
