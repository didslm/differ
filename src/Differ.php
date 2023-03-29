<?php

namespace Didslm\Differ;

class Differ
{
    private static ?ObjectDiffer $instance = null;

    private function __construct() {}
    public static function setBase(object|array $base): void
    {
        if (self::$instance === null) {
            self::$instance = new ObjectDiffer();
        }

        self::$instance->setBase($base);
    }
    public static function getChanges(object|array $compare): array
    {
        if (self::$instance === null) {
            throw new \Exception('You must set a base object before comparing');
        }

        return self::$instance->getChanges($compare);
    }

    public static function hasChanges(object|array $compare): bool
    {
        if (self::$instance === null) {
            throw new \Exception('You must set a base object before comparing');
        }

        return self::$instance->hasChanges($compare);
    }
}