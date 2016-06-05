var _paq = _paq || [];
if(document.getElementById("RegisterSuccess") != null && document.getElementById("RegisterReferrer") != null){
    _paq.push(['setRegisterUserName', document.getElementById("RegisterSuccess").value]);
    _paq.push(['setRegisterTimeStamp', 1]);
    _paq.push(['setRegisterReferrers', document.getElementById("RegisterReferrer").value]);
}
_paq.push(['setFlag', 0]);
_paq.push(['trackPageView']);
(function() {
    var u="//tj.sasa8.com/";
    _paq.push(['setTrackerUrl', u+'stat/index']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'stat.js'; s.parentNode.insertBefore(g,s);
})();
