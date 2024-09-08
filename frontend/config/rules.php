<?php

return [
    //    '/sitemap_index.xml' => '/sitemap',
    //    '/article.xml' => '/sitemap/article',
    //    '/article_category.xml' => '/sitemap/article_category',
    //    '/authors.xml' => '/sitemap/authors',
    //    '/park.xml' => '/sitemap/park',
    //    '/safari_operator.xml' => '/sitemap/safari_operator',
    //    '/shared_safari.xml' => '/sitemap/shared_safari',
    //    '/walkintothewild_pages.xml' => '/sitemap/walkintothewild_pages',
    //    '/article_tag.xml' => '/sitemap/article_tag',
    // '/animal/<slug>' => '/animal/index', //home Page url
    //'/home' => '/plan-safari', //home Page url
    '/sub-category/<category>/<subCategory>' => '/sub-category/view',
    '/contact-us' => '/contact',
    '/park/<slug>' => '/park/default/view', //park view url
    '/park/<slug>/operator' => '/park/default/operator',
    '/park/<slug>/sharedsafari' => '/park/default/sharedsafari',
    '/park/<slug>/discussion' => '/park/default/discussion',
    '/park/<slug>/update' => '/park/default/update',
    '/park/<slug>/package' => '/park/default/package',
    '/park/<slug>/reviewlist' => '/park/default/reviewlist', //park view url
    '/park/<slug>/contributionlist' => '/park/default/contributionlist', //park view url
    '/park' => '/park/default/index', //home-old page url

    // '/park/<master_location_id:\w+>/<session_id:\w+>/<master_animal_id:\w+>/<master_vehicle_id:\w+>' => '/park/default/index',
    // '/park' => '/park/default/index', //park listing url
    '/animal/<slug>' => '/park/default/rareanimal', //park listing url

    '/article' => '/article/default/index',
    '/article/default/validate-comment' => '/article/default/validate-comment',
    '/article/default/validate-reply' => '/article/default/validate-reply',
    '/article/tag/<slug>' => '/article/default/tag',
    [
        'pattern' => '/article/tag/<slug:\w+>',
        'route' => '/article/default/tag',
        'defaults' => ['slug' => '']
    ],
    '/article/topic/<slug>' => '/article/default/topic',
    [
        'pattern' => '/article/topic/<slug:\w+>',
        'route' => '/article/default/topic',
        'defaults' => ['slug' => '']
    ],
    '/article/author/<slug>' => '/article/default/author',
    [
        'pattern' => '/article/author/<slug:\w+>',
        'route' => '/article/default/author',
        'defaults' => ['slug' => '']
    ],
    '/article/<slug>' => '/article/default/view', //article view url



    // Shared Safari URLs
    '/sharedsafari' => '/sharedsafari/default/index',
    '/sharedsafari/organize-safari' => '/sharedsafari/default/organize-safari',
    '/sharedsafari/default/getparkimage' => '/sharedsafari/default/getparkimage',
    '/sharedsafari/default/dynamicsharedseat' => '/sharedsafari/default/dynamicsharedseat',
    '/sharedsafari/default/validate' => '/sharedsafari/default/validate',
    '/sharedsafari/default/updatevalidate' => '/sharedsafari/default/updatevalidate',
    '/sharedsafari/default/update' => '/sharedsafari/default/update',
    '/sharedsafari/default/flag' => '/sharedsafari/default/flag',
    '/sharedsafari/default/reply' => '/sharedsafari/default/reply',
    '/sharedsafari/default/validateflag' => '/sharedsafari/default/validateflag',
    '/sharedsafari/default/validate-comment' => '/sharedsafari/default/validate-comment',
    '/sharedsafari/default/validate-reply' => '/sharedsafari/default/validate-reply',
    '/sharedsafari/default/interestview' => '/sharedsafari/default/interestview',
    '/sharedsafari/month/<month>' => '/sharedsafari/default/month', //url for site xml
    '/sharedsafari/<organized_slug>/<slug>/join' => '/sharedsafari/default/join',
    '/sharedsafari/<organized_slug>/<slug>/unjoin' => '/sharedsafari/default/unjoin',
    '/sharedsafari/<organized_slug>/<slug>/wishlist' => '/sharedsafari/default/wishlist', //sharedsafari page url
    '/sharedsafari/<organized_slug>/<slug>/unwishlist' => '/sharedsafari/default/unwishlist', //sharedsafari page url
    '/sharedsafari/<organized_slug>/<slug>' => '/sharedsafari/default/view',

    '/operator/resort/<id>' => '/operator/default/resort', //operator view url
    '/operator/shared-safari/<id>' => '/operator/default/shared-safari', //operator view url
    '/operator/<slug>/sharedsafariseeall' => '/operator/default/sharedsafariseeall',
    '/operator/review/<id>' => '/operator/default/review', //operator view url
    '/operator/<slug>/follow' => '/operator/default/follow',
    '/operator/<slug>/unfollow' => '/operator/default/unfollow',
    '/operator/<slug>/reviewlist' => '/operator/default/reviewlist', //operator view url
    '/operator/<slug>/package' => '/operator/default/package', //operator view url
    '/operator/<slug>/packageseeall' => '/operator/default/packageseeall',
    '/operator/<slug>/article' => '/operator/default/article', //operator view url
    '/operator/<slug>/articleall' => '/operator/default/articleall',
    '/operator/<slug>/contact' => '/operator/default/contact', //operator view url
    '/operator/<slug>/follower' => '/operator/default/follower',
    '/operator/<slug>/report-operator' => '/operator/default/report-operator',
    '/operator/<slug>/sharedsafari' => '/operator/default/sharedsafari', //operator view url
    '/operator/<slug>/park' => '/operator/default/view', //operator view url
    '/operator/<slug>/parkseeall' => '/operator/default/parkseeall',
    '/operator/<slug>' => '/operator/default/sharedsafari', //operator view url

    '/package' => '/package/default/index', //package page url
    '/package/default/flag' => '/package/default/flag',
    '/package/default/reply' => '/package/default/reply',
    '/package/default/validate-reply' => '/package/default/validate-reply',
    '/package/default/validate-comment' => '/package/default/validate-comment',
    '/package/default/validateflag' => '/package/default/validateflag',
    '/package/month/<month>' => '/package/default/month', //url for site xml
    '/package/<operator_slug>/<slug>/wishlist' => '/package/default/wishlist', //package page url
    '/package/<operator_slug>/<slug>/unwishlist' => '/package/default/unwishlist', //package page url
    '/package/<operator_slug>/<slug>' => '/package/default/view', //package page url

    '/profile/user-experience' => '/profile/default/create',
    '/profile/user/<user_handle>' => '/profile/default/index',
    '/profile/follower/<user_handle>' => '/profile/default/follower',
    '/profile/following/<user_handle>' => '/profile/default/following',
    '/profile/follow/<user_handle>' => '/profile/default/follow',
    '/profile/unfollow/<user_handle>' => '/profile/default/unfollow',


    '/profile/article/validate' => '/profile/article/validate',
    '/profile/article/validate-comment' => '/profile/article/validate-comment',
    '/profile/article/validate-reply' => '/profile/article/validate-reply',
    '/profile/article/create' => '/profile/article/create',
    '/profile/article/reply' => '/profile/article/reply',
    '/profile/article/flag' => '/profile/article/flag',
    '/profile/article/update/<slug>' => '/profile/article/update',
    '/profile/article/<user_handle>/<slug>' => '/profile/article/view',
    '/profile/article/<user_handle>' => '/profile/article/index',

    [
        'pattern' => '/profile/article/validate/<id:\w+>',
        'route' => '/profile/article/validate',
        'defaults' => ['id' => '']
    ],




    '/profile/share-safari-all/<user_handle>' => '/profile/share-safari/viewall',
    '/profile/share-safari/<user_handle>' => '/profile/share-safari/index',
    '/profile/activity/<user_handle>' => '/profile/activity/index',
    '/profile/photo/delete' => '/profile/photo/delete',
    '/profile/photo/validate' => '/profile/photo/validate',
    '/profile/photo/create' => '/profile/photo/create',
    '/profile/photo/<user_handle>' => '/profile/photo/index',
    '/profile/photo/photoseeall/<user_handle>' => '/profile/photo/photoseeall',
    '/profile/contribution/<user_handle>' => '/profile/contribution/index',


    '/profile/search' => '/profile/search/index',
    '/profile/search/blocked/<user_handle>' => '/profile/search/blocked',
    '/profile/search/unblocked/<id>' => '/profile/search/unblocked',


    '/manage/package/update/<package_id>' => '/manage/package/update',
    '/manage/package/view/<package_id>' => '/manage/package/view',
    '/manage/package/itinerary/<package_id>/<day>' => '/manage/package/itinerary', //package profile itenary url          
    '/manage/package/inclusion/<package_id>' => '/manage/package/inclusion', //package profile inclusion url          
    '/manage/package/getting-there/<package_id>' => '/manage/package/getting-there', //package profile getting-there url          
    '/manage/package/policy-info/<package_id>' => '/manage/package/policy-info', //package profile policy-info url          
    '/manage/package/faq/<package_id>' => '/manage/package/faq', //package profile faq url          
    '/manage/package/create-faq/<package_id>' => '/manage/package/create-faq', //package profile create faq url          
    '/manage/package/select-faq/<package_id>' => '/manage/package/select-faq',
    '/manage/package/gallery/<package_id>' => '/manage/package/gallery', //package profile faq url          
    '/manage/package/create-gallery/<package_id>' => '/manage/package/create-gallery', //package profile create faq url          


    '/manage/sharedsafari/update-fixed-departure/<slug>' => '/manage/sharedsafari/update-fixed-departure',
    '/manage/sharedsafari/itinerary/<slug>/<day>' => '/manage/sharedsafari/itinerary', //sharedsafari profile itenary url          
    '/manage/sharedsafari/inclusion/<slug>' => '/manage/sharedsafari/inclusion', //sharedsafari profile inclusion url          
    '/manage/sharedsafari/getting-there/<slug>' => '/manage/sharedsafari/getting-there', //sharedsafari profile getting-there url          
    '/manage/sharedsafari/policy-info/<slug>' => '/manage/sharedsafari/policy-info', //sharedsafari profile policy-info url          
    '/manage/sharedsafari/faq/<slug>' => '/manage/sharedsafari/faq', //sharedsafari profile faq url          
    '/manage/sharedsafari/create-faq/<slug>' => '/manage/sharedsafari/create-faq', //sharedsafari profile create faq url          
    '/manage/sharedsafari/select-faq/<slug>' => '/manage/sharedsafari/select-faq',
    '/manage/sharedsafari/gallery/<slug>' => '/manage/sharedsafari/gallery', //sharedsafari profile faq url          
    '/manage/sharedsafari/create-gallery/<slug>' => '/manage/sharedsafari/create-gallery',
    '/manage/sharedsafari/view/<slug>' => '/manage/sharedsafari/view', //sharedsafari profile create faq url 
    '/manage/sharedsafari/comment/<slug>' => '/manage/sharedsafari/comment',

    '/manage/article/update/<slug>' => '/manage/article/update',

    // Chat Routes
    '/chat/message/<user_handle>' => '/chat/default/message',
    '/chat/message/<user_handle>/<chat_id>' => '/chat/default/message',
    '/chat/quote/<user_handle>/<chat_id>' => '/chat/default/message',
    '/site/signinagree/<key>' => '/site/signinagree',
    '/site/verify/<passcode>' => '/site/login-new-verify',

    // '/account/<id>' => '/account/default/index',
];
