/**
 * Created by oba on 2016/3/8.
 */
var _paq = _paq || [];
if(document.getElementById("__RegisteSuccess__") != null){
    _paq.push(['setUserId',document.getElementById("__RegisteSuccess__").value]);
    _paq.push(['setCustomVariable',1,'regTime',Date.parse(new Date())/1000,'visit']);
}
_paq.push(['trackPageView']);
_paq.push(['enableLinkTracking']);
(function() {
    var u="//p.wo2365.com/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
})();