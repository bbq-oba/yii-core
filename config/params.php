<?php

return [
    'adminEmail' => 'admin@example.com',
    'mdm.admin.configs'=>[
        'cacheDuration' => 295200
        /*
         * +这句可以解决一个莫名其妙的bug，
         * Redis error: ERR invalid expire time in SETEX
         * cacheDuration = -1702967296
         * */
    ],
    'stat'=>[
        'General'=>[
//; character used to automatically create categories in the Actions > Pages, Outlinks and Downloads reports
//; for example a URL like "example.com/blog/development/first-post" will create
//; the page first-post in the subcategory development which belongs to the blog category
//action_url_category_delimiter = /
            'action_url_category_delimiter' =>'/',

        ],
        'setting'=>[
            'salt'=>'47bf71d96037cd835cb1812135d37d2d',
        ],
        'Debug'=>[
//; If set to 1, all requests to piwik.php will be forced to be 'new visitors'
//tracker_always_new_visitor = 0
          'tracker_always_new_visitor'=> 0 ,
        ],
        'Tracker'=>[
//; This setting is described in this FAQ: http://piwik.org/faq/how-to/faq_175/
//; Note: generally this should only be set to 1 in an intranet setting, where most users have the same configuration (browsers, OS)
//; and the same IP. If left to 0 in this setting, all visitors will be counted as one single visitor.
//trust_visitors_cookies = 0
            'trust_visitors_cookies'=> 0 ,

//; The window to look back for a previous visit by this current visitor. Defaults to visit_standard_length.
//; If you are looking for higher accuracy of "returning visitors" metrics, you may set this value to 86400 or more.
//; This is especially useful when you use the Tracking API where tracking Returning Visitors often depends on this setting.
//; The value window_look_back_for_visitor is used only if it is set to greater than visit_standard_length
//window_look_back_for_visitor = 0
            'window_look_back_for_visitor' => 0,

//; Piwik uses "Privacy by default" model. When one of your users visit multiple of your websites tracked in this Piwik,
//; Piwik will create for this user a fingerprint that will be different across the multiple websites.
//; If you want to track unique users across websites (for example when using the InterSites plugin) you may set this setting to 1.
//; Note: setting this to 0 increases your users' privacy.
//enable_fingerprinting_across_websites = 0
            'enable_fingerprinting_across_websites' => 0,

            'use_third_party_id_cookie' => 0,
            'visit_standard_length'=>1800,
//; maximum length of a Page Title or a Page URL recorded in the log_action.name table
//page_maximum_length = 1024;
            'page_maximum_length' => 1024 ,

//; Comma separated list of variable names that will be read to define a Campaign name, for example CPC campaign
//; Example: If a visitor first visits 'index.php?piwik_campaign=Adwords-CPC' then it will be counted as a campaign referrer named 'Adwords-CPC'
//; Includes by default the GA style campaign parameters
//campaign_var_name = "pk_cpn,pk_campaign,piwik_campaign,utm_campaign,utm_source,utm_medium"
            'campaign_var_name' => "pk_cpn,pk_campaign,piwik_campaign,utm_campaign,utm_source,utm_medium",

//; Comma separated list of variable names that will be read to track a Campaign Keyword
//; Example: If a visitor first visits 'index.php?piwik_campaign=Adwords-CPC&piwik_kwd=My killer keyword' ;
//; then it will be counted as a campaign referrer named 'Adwords-CPC' with the keyword 'My killer keyword'
//; Includes by default the GA style campaign keyword parameter utm_term
//campaign_keyword_var_name = "pk_kwd,pk_keyword,piwik_kwd,utm_term"
            'campaign_keyword_var_name' => "pk_kwd,pk_keyword,piwik_kwd,utm_term" ,



        ],
        'TrackerConfig'=>[
            'cookie_path'=>'',
            'cookie_expire'=>33955200,
            'cookie_name'=>'_pk_uid',
            'tracking_requests_require_authentication'=>1,


        ],
    ],
];
