<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sub-Domain Routing
    |--------------------------------------------------------------------------
    |
    | This value represents the "domain name" associated with your application.
    | This value is used when the framework needs to place the application's
    | name in a notification or any other location as required by the application.
    |
    */

    'domain' => env('DASHBOARD_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Route Prefixes
    |--------------------------------------------------------------------------
    |
    | This prefix method can be used to specify the prefix of each route in
    | your Orchid dashboard. You can also pass a value of null to disable prefixing
    | of the dashboard routes.
    |
    | Example: '/', '/admin', '/panel'
    |
    */

    'prefix' => env('DASHBOARD_PREFIX', '/admin'),

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    | This middleware will be assigned to every route in Orchid,
    | giving you the ability to add your own middleware to this stack or override any of
    | the existing middleware.
    |
    */

    'middleware' => [
        'public'  => ['web'],
        'private' => ['web', 'platform'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Guard
    |--------------------------------------------------------------------------
    |
    | This can be used if you are using a multi-auth setup configured.
    | Such as using an Admin model for Orchid and User Model for frontend access.
    | If not using default auth guard remember to add 'auth:guard_name' to the middleware
    | where guard_name is the custom guard name.
    |
    | Example: 'web', 'admin'
    |
    */

    'guard' => config('auth.defaults.guard', 'web'),

    /*
    |--------------------------------------------------------------------------
    | Auth Page
    |--------------------------------------------------------------------------
    |
    | The property controls the visibility of Orchid's built-in authentication pages.
    | You can disable this page and use your own set like 'Jetstream'
    | You can inject your own form by changing the authorization form view.
    |
    | Example: 'platform::auth.login'
    |
    */

    'auth'  => true,
    'auth_view' => 'platform::auth.login',

    /*
    |--------------------------------------------------------------------------
    | Main Route
    |--------------------------------------------------------------------------
    |
    | The main page of the application is recorded as the name of the route,
    | it will be opened by users when they enter or click on logos and links.
    |
    */

    'index' => 'platform.index',

    /*
    |--------------------------------------------------------------------------
    | Dashboard Resource
    |--------------------------------------------------------------------------
    |
    | Automatically connect the stored links.
    |
    | Example: '/resources/js/dashboard.js', '/resources/js/dashboard.css'
    |
    */

    'resource' => [
        'stylesheets' => [],
        'scripts'     => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Template view
    |--------------------------------------------------------------------------
    |
    | Templates that will be displayed in the application and used pages,
    | allowing to customize the part of the user interface that is
    | suitable for specifying the name, logo, accompanying documents, etc.
    |
    | Example: Path to your file '/views/brand/header.blade.php',
    | then its value should be 'brand.header'
    |
    */

    'template' => [
        'header' => 'platform::header',
        'footer' => 'platform::footer',
    ],

    /*
    |--------------------------------------------------------------------------
    | Default configuration for attachments.
    |--------------------------------------------------------------------------
    |
    | Strategy properties for the file and storage used.
    |
    */

    'attachment' => [
        'disk'      => 'public',
        'generator' => \Orchid\Attachment\Engines\Generator::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Icons Path
    |--------------------------------------------------------------------------
    |
    | Provide the path from your app to your SVG icons directory.
    |
    | Example: [ 'fa' => storage_path('app/fontawesome') ]
    */

    'icons' => [
        'orc' => \Orchid\IconPack\Path::getFolder(),
    ],

    // 'icons' => [
    //     'orc' => \App\Utils\CustomIconPack::getFolder(),
    // ],


    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    |
    | It are a great way to inform your users of things that are happening
    | in your application. These notifications are viewable by clicking on
    | the "notification bell" icon in the application's navigation bar.
    | The notification bell will have an unread count indicator when
    | there are unread announcements or notifications.
    |
    | By default, the interval update for one minute.
    */

    'notifications' => [
        'enabled'  => true,
        'interval' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Search
    |--------------------------------------------------------------------------
    |
    | List of models containing a Presenter and Scout,
    | which allows you to search for records in the application.
    |
    */

    'search' => [
        // \App\Models\User::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Hotwire Turbo
    |--------------------------------------------------------------------------
    |
    | Turbo Drive maintains a cache of recently visited pages.
    | This cache serves two purposes: to display pages without accessing
    | the network during restoration visits, and to improve perceived
    | performance by showing temporary previews during application visits.
    |
    */

    'turbo' => [
        'cache' => true
    ],

    /*
    |--------------------------------------------------------------------------
    | Fallback Page
    |--------------------------------------------------------------------------
    |
    | If the request does not match with any of the routes defined in the routing
    | the package will look for a page match using slugs.
    */

    'fallback' => true,

    /*
    |--------------------------------------------------------------------------
    | Service Provider
    |--------------------------------------------------------------------------
    |
    | This value is a class namespace of the platform's service provider
    | to bind in to the application. This value is used when the
    | framework needs to place the application's service provider.
    |
    */

    'provider' => \App\Orchid\PlatformProvider::class,

];

