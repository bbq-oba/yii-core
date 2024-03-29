<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace app\stat;

use Piwik\Network\IPUtils;

/**
 * Contains IP address helper functions (for both IPv4 and IPv6).
 *
 * As of Piwik 2.9, most methods in this class are deprecated. You are
 * encouraged to use classes from the Piwik "Network" component:
 *
 * @see \Piwik\Network\IP
 * @see \Piwik\Network\IPUtils
 * @link https://github.com/piwik/component-network
 *
 * As of Piwik 1.3, IP addresses are stored in the DB has VARBINARY(16),
 * and passed around in network address format which has the advantage of
 * being in big-endian byte order. This allows for binary-safe string
 * comparison of addresses (of the same length), even on Intel x86.
 *
 * As a matter of naming convention, we use `$ip` for the network address format
 * and `$ipString` for the presentation format (i.e., human-readable form).
 *
 * We're not using the network address format (in_addr) for socket functions,
 * so we don't have to worry about incompatibility with Windows UNICODE
 * and inetPtonW().
 *
 * @api
 */
class IP
{
    /**
     * Returns the most accurate IP address availble for the current user, in
     * IPv4 format. This could be the proxy client's IP address.
     *
     * @return string IP address in presentation format.
     */
    public static function getIpFromHeader()
    {
        $clientHeaders = array();

        $default = '0.0.0.0';
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $default = $_SERVER['REMOTE_ADDR'];
        }

        $ipString = self::getNonProxyIpFromHeader($default, $clientHeaders);
        return IPUtils::sanitizeIp($ipString);
    }

    /**
     * Returns a non-proxy IP address from header.
     *
     * @param string $default Default value to return if there no matching proxy header.
     * @param array $proxyHeaders List of proxy headers.
     * @return string
     */
    public static function getNonProxyIpFromHeader($default, $proxyHeaders)
    {
        $proxyIps = array();
        $config = \yii::$app->params;
        if (isset($config['proxy_ips'])) {
            $proxyIps = $config['proxy_ips'];
        }
        if (!is_array($proxyIps)) {
            $proxyIps = array();
        }

        $proxyIps[] = $default;

        // examine proxy headers
        foreach ($proxyHeaders as $proxyHeader) {
            if (!empty($_SERVER[$proxyHeader])) {
                // this may be buggy if someone has proxy IPs and proxy host headers configured as
                // `$_SERVER[$proxyHeader]` could be eg $_SERVER['HTTP_X_FORWARDED_HOST'] and
                // include an actual host name, not an IP
                $proxyIp = self::getLastIpFromList($_SERVER[$proxyHeader], $proxyIps);
                if (strlen($proxyIp) && stripos($proxyIp, 'unknown') === false) {
                    return $proxyIp;
                }
            }
        }

        return $default;
    }

    /**
     * Returns the last IP address in a comma separated list, subject to an optional exclusion list.
     *
     * @param string $csv Comma separated list of elements.
     * @param array $excludedIps Optional list of excluded IP addresses (or IP address ranges).
     * @return string Last (non-excluded) IP address in the list or an empty string if all given IPs are excluded.
     */
    public static function getLastIpFromList($csv, $excludedIps = null)
    {
        $p = strrpos($csv, ',');
        if ($p !== false) {
            $elements = explode(',', $csv);
            for ($i = count($elements); $i--;) {
                $element = trim(Common::sanitizeInputValue($elements[$i]));
                $ip = \Piwik\Network\IP::fromStringIP(IPUtils::sanitizeIp($element));
                if (empty($excludedIps) || (!in_array($element, $excludedIps) && !$ip->isInRanges($excludedIps))) {
                    return $element;
                }
            }

            return '';
        }
        return trim(Common::sanitizeInputValue($csv));
    }
}
