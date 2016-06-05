if (typeof _paq !== 'object') {
    _paq = [];
}

if (typeof Piwik !== 'object') {
    Piwik = (function () {
        'use strict';
        var expireDateTime,
            documentAlias = document,
            windowAlias = window,
        /* encode */
            encodeWrapper = windowAlias.encodeURIComponent,

        /* decode */
            decodeWrapper = windowAlias.decodeURIComponent,

        /* urldecode */
            urldecode = unescape,

        /* asynchronous tracker */
            asyncTracker,

        /* iterator */
            iterator,

        /* local Piwik */
            Piwik;

        function isString(property) {
            return typeof property === 'string' || property instanceof String;
        }

        /**
         * Applies the given methods in the given order if they are present in paq.
         *
         * @param {Array} paq
         * @param {Array} methodsToApply an array containing method names in the order that they should be applied
         *                 eg ['setSiteId', 'setTrackerUrl']
         * @returns {Array} the modified paq array with the methods that were already applied set to undefined
         */
        function applyMethodsInOrder(paq, methodsToApply)
        {
            var appliedMethods = {};
            var index, iterator;

            for (index = 0; index < methodsToApply.length; index++) {
                var methodNameToApply = methodsToApply[index];
                appliedMethods[methodNameToApply] = 1;

                for (iterator = 0; iterator < paq.length; iterator++) {
                    if (paq[iterator] && paq[iterator][0]) {
                        var methodName = paq[iterator][0];

                        if (methodNameToApply === methodName) {
                            apply(paq[iterator]);
                            delete paq[iterator];

                            if (appliedMethods[methodName] > 1) {
                                if (console !== undefined && console && console.error) {
                                    console.error('The method ' + methodName + ' is registered more than once in "paq" variable. Only the last call has an effect. Please have a look at the multiple Piwik trackers documentation: http://developer.piwik.org/guides/tracking-javascript-guide#multiple-piwik-trackers');
                                }
                            }

                            appliedMethods[methodName]++;
                        }
                    }
                }
            }

            return paq;
        }


        function apply() {
            var i, f, parameterArray;

            for (i = 0; i < arguments.length; i += 1) {
                parameterArray = arguments[i];
                f = parameterArray.shift();
                if (isString(f)) {
                    asyncTracker[f].apply(asyncTracker, parameterArray);
                } else {
                    f.apply(asyncTracker, parameterArray);
                }
            }
        }
        function getHostName(url) {
            // scheme : // [username [: password] @] hostame [: port] [/ [path] [? query] [# fragment]]
            var e = new RegExp('^(?:(?:https?|ftp):)/*(?:[^@]+@)?([^:/#]+)'),
                matches = e.exec(url);

            return matches ? matches[1] : url;
        }

        function getReferrer() {
            var referrer = '';

            try {
                referrer = windowAlias.top.document.referrer;
            } catch (e) {
                if (windowAlias.parent) {
                    try {
                        referrer = windowAlias.parent.document.referrer;
                    } catch (e2) {
                        referrer = '';
                    }
                }
            }

            if (referrer === '') {
                referrer = documentAlias.referrer;
            }

            return referrer;
        }
        function urlFixup(hostName, href, referrer) {
            if (hostName === 'translate.googleusercontent.com') {       // Google
                if (referrer === '') {
                    referrer = href;
                }

                href = getParameter(href, 'u');
                hostName = getHostName(href);
            } else if (hostName === 'cc.bingj.com' ||                   // Bing
                hostName === 'webcache.googleusercontent.com' ||    // Google
                hostName.slice(0, 5) === '74.6.') {                 // Yahoo (via Inktomi 74.6.0.0/16)
                href = documentAlias.links[0].href;
                hostName = getHostName(href);
            }

            return [hostName, href, referrer];
        }

        function getParameter(url, name) {
            var regexSearch = "[\\?&#]" + name + "=([^&#]*)";
            var regex = new RegExp(regexSearch);
            var results = regex.exec(url);
            return results ? decodeWrapper(results[1]) : '';
        }
        function safeDecodeWrapper(url) {
            try {
                return decodeWrapper(url);
            } catch (e) {
                return unescape(url);
            }
        }

        function Tracker(trackerUrl ,siteId) {
            var expireDateTime,
                configTrackerUrl = trackerUrl || '',
                registerUserName,
                registerTimeStamp,
                registerReferrers,
                flag,
                locationArray = urlFixup(documentAlias.domain, windowAlias.location.href, getReferrer()),
                currentUrl = safeDecodeWrapper(locationArray[1]),
                timeNextTrackingRequestCanBeExecutedImmediately = false,
                lastTrackerRequestTime = null,
                configReferrerUrl = safeDecodeWrapper(locationArray[2]);


            function setExpireDateTime(delay) {

                var now = new Date();
                var time = now.getTime() + delay;

                if (!expireDateTime || time > expireDateTime) {
                    expireDateTime = time;
                }
            }

            function logPageView() {

                var request = '&url=' + encodeWrapper(purify(currentUrl)) +
                    (configReferrerUrl.length ? '&urlref=' + encodeWrapper(purify(configReferrerUrl)) : '') +
                    (typeof registerUserName == 'undefined' ? '' :'&ru='+registerUserName) +
                    (typeof registerTimeStamp == 'undefined' ? '' :'&rt='+registerTimeStamp) +
                    (typeof registerReferrers == 'undefined' ? '' :'&rr='+registerReferrers) +
                    (typeof flag == 'undefined' ? '' :'&rf='+flag) ;

                getImage(request);
            }


            function getImage(request) {
                var image = new Image(1, 1);
                image.src = configTrackerUrl + (configTrackerUrl.indexOf('?') < 0 ? '?' : '&') + request;
            }

            function purify(url) {
                var targetPattern;
                targetPattern = new RegExp('#.*');
                return url.replace(targetPattern, '');
            }

            return {
                setTrackerUrl: function (trackerUrl) {
                    configTrackerUrl = trackerUrl;
                },
                trackPageView: function () {
                    logPageView();
                },
                setRegisterUserName:function(val){
                    registerUserName = val;
                },
                setRegisterTimeStamp:function(val){
                    registerTimeStamp = val
                },
                setRegisterReferrers:function(val){
                    registerReferrers = val;
                },
                setFlag:function(val){
                    flag = val;
                }

            }
        }
        asyncTracker = new Tracker();

        var applyFirst  = ['setTrackerUrl'];
        _paq = applyMethodsInOrder(_paq, applyFirst);

        for (iterator = 0; iterator < _paq.length; iterator++) {
            if (_paq[iterator]) {
                apply(_paq[iterator]);
            }
        }
    }());
}
