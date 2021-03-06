<?php

namespace ChillPills\InstagramBasicFeed;

use Illuminate\Support\Facades\Cache;

class InstagramBasicFeed
{
    protected $medias;

    public function __construct()
    {
        $this->medias = Cache::get(InstagramFeedCrawler::$cacheKey, []);
    }

    public function getUserMedias()
    {
        return $this->medias;
    }

    public function getUserMediasWithHashtag($hashtag)
    {
        if (empty($hashtag)) {
            return $this->getUserMedias();
        }

        $mediaMatch = [];

        foreach ($this->medias as $media) {
            if (isset($media->caption) && strpos($media->caption, $hashtag) !== false) {
                $mediaMatch[] = $media;
            }
        }

        return $mediaMatch;
    }
}
