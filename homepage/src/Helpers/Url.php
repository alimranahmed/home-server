<?php

namespace Alimranahmed\HomeServerHomepage\Helpers;

class Url
{
    public static function host(): string {
        return getenv('HOST_IP') ?: '127.0.0.1';
    }

    public static function withPort(string $port): string {
        return 'http://' . self::host() . ":$port";
    }
}