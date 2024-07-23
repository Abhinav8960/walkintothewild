<?php

return [
    '/home' => '/plan-safari', //home Page url
    '/park' => '/park/default/index', //home-old page url
    '/park/<slug>' => '/park/default/view', //park view url
    '/park/reviewlist/<slug>' => '/park/default/reviewlist', //park view url
    '/park/contributionlist/<slug>' => '/park/default/contributionlist', //park view url

    '/parklist/<master_location_id:\w+>/<session_id:\w+>/<master_animal_id:\w+>/<master_vehicle_id:\w+>' => '/park/default/parklist',
    '/parklist' => '/park/default/parklist', //park listing url
    '/rareanimal/<slug>' => '/park/default/rareanimal', //park listing url

    '/article' => '/article/default/index',
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
    '/sharedsafari/default/validate' => '/sharedsafari/default/validate',
    '/sharedsafari/default/update' => '/sharedsafari/default/update',
    '/sharedsafari/default/join' => '/sharedsafari/default/join',
    '/sharedsafari/default/unjoin' => '/sharedsafari/default/unjoin',
    '/sharedsafari/default/organize-safari' => '/sharedsafari/default/organize-safari',
    '/sharedsafari/<slug>' => '/sharedsafari/default/view',
    '/sharedsafari/wishlist/<slug>' => '/sharedsafari/default/wishlist', //sharedsafari page url
    '/sharedsafari/unwishlist/<slug>' => '/sharedsafari/default/unwishlist', //sharedsafari page url

    '/operator/manage/sharedsafari' => '/operator/manage/sharedsafari',
    '/operator/manage/package' => '/operator/manage/package',
    '/operator/manage' => '/operator/manage/index', //operator manage
    '/operator/manage/park' => '/operator/manage/park', //operator manage
    '/operator/resort/<id>' => '/operator/default/resort', //operator view url
    '/operator/shared-safari/<id>' => '/operator/default/shared-safari', //operator view url
    '/operator/review/<id>' => '/operator/default/review', //operator view url
    '/operator/<slug>/reviewlist' => '/operator/default/reviewlist', //operator view url
    '/operator/<slug>/sharedsafari' => '/operator/default/sharedsafari', //operator view url
    '/operator/<slug>' => '/operator/default/view', //operator view url

    '/package' => '/package/default/index', //package page url
    '/package/<slug>' => '/package/default/view', //package page url
    '/package/wishlist/<slug>' => '/package/default/wishlist', //package page url
    '/package/unwishlist/<slug>' => '/package/default/unwishlist', //package page url
    '/package/profile/<package_id>' => '/package/profile/index', //package profile  url          
    '/package/profile/itinerary/<package_id>/<day>' => '/package/profile/itinerary', //package profile itenary url          
    '/package/profile/inclusion/<package_id>' => '/package/profile/inclusion', //package profile inclusion url          
    '/package/profile/getting-there/<package_id>' => '/package/profile/getting-there', //package profile getting-there url          
    '/package/profile/policy-info/<package_id>' => '/package/profile/policy-info', //package profile policy-info url          
    '/package/profile/faq/<package_id>' => '/package/profile/faq', //package profile faq url          
    '/package/profile/create-faq/<package_id>' => '/package/profile/create-faq', //package profile create faq url          
    '/package/profile/select-faq/<package_id>' => '/package/profile/select-faq', //package profile select faq url     


    '/profile/user/<user_handle>' => '/profile/default/index',
    '/profile/follower/<user_handle>' => '/profile/default/follower',
    '/profile/following/<user_handle>' => '/profile/default/following',
    '/profile/blocked/<user_handle>' => '/profile/default/blocked',

    '/profile/article/validate' => '/profile/article/validate',
    '/profile/article/create' => '/profile/article/create',
    '/profile/article/update/<slug>' => '/profile/article/update',
    '/profile/article/<user_handle>' => '/profile/article/index',

    [
        'pattern' => '/profile/article/validate/<id:\w+>',
        'route' => '/profile/article/validate',
        'defaults' => ['id' => '']
    ],




    '/profile/share-safari/<user_handle>' => '/profile/share-safari/index',
    '/profile/activity/<user_handle>' => '/profile/activity/index',
    '/profile/photo/<user_handle>' => '/profile/photo/index',
    '/profile/contribution/<user_handle>' => '/profile/contribution/index',
];
