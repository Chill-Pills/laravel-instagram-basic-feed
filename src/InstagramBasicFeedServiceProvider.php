<?php

namespace ChillPills\InstagramBasicFeed;

use ChillPills\InstagramBasicFeed\Console\InstagramCrawlFeed;
use ChillPills\InstagramBasicFeed\Console\InstagramGetAuthorizationUrl;
use ChillPills\InstagramBasicFeed\Console\InstagramRefreshAccessToken;
use ChillPills\InstagramBasicFeed\Console\InstagramSetNewAccessToken;
use Illuminate\Support\ServiceProvider;

class InstagramBasicFeedServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstagramCrawlFeed::class,
                InstagramRefreshAccessToken::class,
                InstagramGetAuthorizationUrl::class,
                InstagramSetNewAccessToken::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'instagram-basic-feed');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/instagram-basic-feed'),
        ], 'instagram-basic-feed-views');

        $this->publishes([
            __DIR__.'/../config/instagram-basic-feed.php' => base_path('config/instagram-basic-feed.php'),
        ], 'instagram-basic-feed-config');
    }

    public function register()
    {
        $this->app->bind('instagram-basic-feed', function () {
            return new InstagramBasicFeed();
        });

        $this->mergeConfigFrom(__DIR__.'/../config/instagram-basic-feed.php', 'instagram-basic-feed');
    }
}
