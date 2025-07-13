<?php

namespace Alimranahmed\HomeServerHomepage\Helpers;

class Url
{
    public static function withPort(string $port): string {
        return 'http://'.getenv('HOST_IP').":$port";
    }
}